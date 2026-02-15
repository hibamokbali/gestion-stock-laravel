<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Direction;
use App\Models\Magasin;
use Illuminate\Http\Request;

class MagasinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $magasins = Magasin::with('direction')->where('actif', true)->latest()->paginate(15);
        return view('admin.magasins.index', compact('magasins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $directions = Direction::where('actif', true)->get();
        return view('admin.magasins.create', compact('directions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'nom_magasin' => 'required|string|max:255',
            'code_magasin' => 'required|string|unique:magasins',
            'emplacement' => 'nullable|string',
            'direction_id' => 'required|exists:directions,id',
        ]);

        Magasin::create($validated);

        return redirect()->route('admin.magasins.index')
            ->with('success', 'Magasin créé avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Magasin $magasin)
    {
        $directions = Direction::where('actif', true)->get();
        return view('admin.magasins.edit', compact('magasin', 'directions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Magasin $magasin)
    {
        $validated = $request->validate([
            'nom_magasin' => 'required|string|max:255',
            'code_magasin' => 'required|string|unique:magasins,code_magasin,' . $magasin->id,
            'emplacement' => 'nullable|string',
            'direction_id' => 'required|exists:directions,id',
        ]);

        $magasin->update($validated);

        return redirect()->route('admin.magasins.index')
            ->with('success', 'Magasin modifié avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Magasin $magasin)
    {
        $magasin->update(['actif' => false]);

        return redirect()->route('admin.magasins.index')
            ->with('success', 'Magasin supprimé avec succès');
    }
}
