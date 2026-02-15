<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Direction;
use App\Models\Employe;
use Illuminate\Http\Request;

class EmployeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employes = Employe::with('direction')->where('actif', true)->latest()->paginate(15);
        return view('admin.employes.index', compact('employes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $directions = Direction::where('actif', true)->get();
        return view('admin.employes.create', compact('directions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'matricule' => 'required|string|unique:employes',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'direction_id' => 'required|exists:directions,id',
            'poste' => 'nullable|string|max:255',
        ]);

        Employe::create($validated);

        return redirect()->route('admin.employes.index')
            ->with('success', 'Employé créé avec succès');
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
    public function edit(Employe $employe)
    {
        $directions = Direction::where('actif', true)->get();
        return view('admin.employes.edit', compact('employe', 'directions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employe $employe)
    {
        $validated = $request->validate([
            'matricule' => 'required|string|unique:employes,matricule,' . $employe->id,
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'direction_id' => 'required|exists:directions,id',
            'poste' => 'nullable|string|max:255',
        ]);

        $employe->update($validated);

        return redirect()->route('admin.employes.index')
            ->with('success', 'Employé modifié avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employe $employe)
    {
        $employe->update(['actif' => false]);

        return redirect()->route('admin.employes.index')
            ->with('success', 'Employé supprimé avec succès');
    }
}
