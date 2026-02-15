<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Entree;
use App\Models\Fournisseur;
use App\Models\Unite;
use Illuminate\Http\Request;

class EntreeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Entree::with(['unite', 'fournisseur', 'user']);

        // Si user simple, voir uniquement ses entrées
        if (!auth()->user()->isAdmin()) {
            $query->where('user_id', auth()->id());
        }

        $entrees = $query->latest()->paginate(15);

        return view('admin.entrees.index', compact('entrees'));
    }

    public function create()
    {
        $unites = Unite::where('actif', true)->get();
        $fournisseurs = Fournisseur::where('actif', true)->get();

        return view('admin.entrees.create', compact('unites', 'fournisseurs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'unite_id' => 'required|exists:unites,id',
            'fournisseur_id' => 'nullable|exists:fournisseurs,id',
            'quantite' => 'required|numeric|min:0.01',
            'prix_unit' => 'nullable|numeric|min:0',
            'date_reception' => 'required|date',
            'numero_bon' => 'nullable|string|max:255',
            'numero_facture' => 'nullable|string|max:255',
        ]);

        $validated['user_id'] = auth()->id();
        // code_entree sera généré automatiquement par le modèle

        Entree::create($validated);

        return redirect()->route(auth()->user()->isAdmin() ? 'admin.entrees.index' : 'user.entrees.index')
            ->with('success', 'Entrée enregistrée avec succès');
    }

    public function show($id)
    {
        $entree = Entree::with(['unite', 'fournisseur', 'user'])->findOrFail($id);

        // Vérifier que le user peut voir cette entrée
        if (!auth()->user()->isAdmin() && $entree->user_id !== auth()->id()) {
            abort(403, 'Accès non autorisé');
        }

        return view('admin.entrees.show', compact('entree'));
    }

    public function edit($id)
    {
        $entree = Entree::findOrFail($id);

        // Vérifier que le user peut modifier cette entrée
        if (!auth()->user()->isAdmin() && $entree->user_id !== auth()->id()) {
            abort(403, 'Accès non autorisé');
        }

        $unites = Unite::where('actif', true)->get();
        $fournisseurs = Fournisseur::where('actif', true)->get();

        return view('admin.entrees.edit', compact('entree', 'unites', 'fournisseurs'));
    }

    public function update(Request $request, $id)
    {
        $entree = Entree::findOrFail($id);

        // Vérifier que le user peut modifier cette entrée
        if (!auth()->user()->isAdmin() && $entree->user_id !== auth()->id()) {
            abort(403, 'Accès non autorisé');
        }

        $validated = $request->validate([
            'unite_id' => 'required|exists:unites,id',
            'fournisseur_id' => 'nullable|exists:fournisseurs,id',
            'quantite' => 'required|numeric|min:0.01',
            'prix_unit' => 'nullable|numeric|min:0',
            'date_reception' => 'required|date',
            'numero_bon' => 'nullable|string|max:255',
            'numero_facture' => 'nullable|string|max:255',
        ]);

        $entree->update($validated);

        return redirect()->route(auth()->user()->isAdmin() ? 'admin.entrees.index' : 'user.entrees.index')
            ->with('success', 'Entrée modifiée avec succès');
    }

    public function destroy($id)
    {
        $entree = Entree::findOrFail($id);

        // Vérifier que le user peut supprimer cette entrée
        if (!auth()->user()->isAdmin() && $entree->user_id !== auth()->id()) {
            abort(403, 'Accès non autorisé');
        }

        $entree->delete();

        return redirect()->route(auth()->user()->isAdmin() ? 'admin.entrees.index' : 'user.entrees.index')
            ->with('success', 'Entrée supprimée avec succès');
    }
}
