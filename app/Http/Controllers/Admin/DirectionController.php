<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Direction;
use Illuminate\Http\Request;

class DirectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $directions = Direction::where('actif', true)->latest()->paginate(15);
        return view('admin.directions.index', compact('directions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.directions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'nom_direction' => 'required|string|max:255',
            'code_direction' => 'required|string|unique:directions',
        ]);

        Direction::create($validated);

        return redirect()->route('admin.directions.index')
            ->with('success', 'Direction créée avec succès');
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
    public function edit(Direction $direction)
    {
        return view('admin.directions.edit', compact('direction'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Direction $direction)
    {
        $validated = $request->validate([
            'nom_direction' => 'required|string|max:255',
            'code_direction' => 'required|string|unique:directions,code_direction,' . $direction->id,
        ]);

        $direction->update($validated);

        return redirect()->route('admin.directions.index')
            ->with('success', 'Direction modifiée avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Direction $direction)
    {
        $direction->update(['actif' => false]);

        return redirect()->route('admin.directions.index')
            ->with('success', 'Direction désactivée avec succès');
    }
}
