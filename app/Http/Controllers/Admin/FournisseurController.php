<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fournisseur;
use Illuminate\Http\Request;

class FournisseurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fournisseurs = Fournisseur::where('actif', true)->latest()->paginate(15);
        return view('admin.fournisseurs.index', compact('fournisseurs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.fournisseurs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom_fournisseur' => 'required|string|max:255',
            'code_fournisseur' => 'required|string|unique:fournisseurs',
            'adresse' => 'nullable|string',
            'telephone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        Fournisseur::create($validated);

        return redirect()->route('admin.fournisseurs.index')
            ->with('success', 'Fournisseur créé avec succès');
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
    public function edit($id)
    {

        $fournisseur = Fournisseur::findOrFail($id);
        return view('admin.fournisseurs.edit', compact('fournisseur'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $fournisseur = Fournisseur::findOrFail($id);

        $validated = $request->validate([
            'nom_fournisseur' => 'required|string|max:255',
            'code_fournisseur' => 'required|string|unique:fournisseurs,code_fournisseur,' . $id,
            'adresse' => 'nullable|string',
            'telephone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        $fournisseur->update($validated);

        return redirect()->route('admin.fournisseurs.index')
            ->with('success', 'Fournisseur modifié avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fournisseur $fournisseur)
    {
        try {
            // Vérifier s'il y a des entrées liées
            $entrees_count = \App\Models\Entree::where('fournisseur_id', $fournisseur->id)->count();

            if ($entrees_count > 0) {
                return redirect()->route('admin.fournisseurs.index')
                    ->with('error', "Impossible de supprimer ce fournisseur : {$entrees_count} entrée(s) lui sont associées.");
            }

            // Suppression réelle
            $fournisseur->delete();

            return redirect()->route('admin.fournisseurs.index')
                ->with('success', 'Fournisseur supprimé définitivement avec succès');
        } catch (\Exception $e) {
            return redirect()->route('admin.fournisseurs.index')
                ->with('error', 'Erreur lors de la suppression : ' . $e->getMessage());
        }
    }
}
