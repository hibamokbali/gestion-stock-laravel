<?php

namespace App\Http\Controllers\Admin;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\Employe;
use App\Models\Sortie;
use App\Models\Unite;
use Illuminate\Http\Request;

class SortieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Sortie::with(['unite', 'employe', 'user']);

        // Si user simple, voir uniquement ses sorties
        if (!auth()->user()->isAdmin()) {
            $query->where('user_id', auth()->id());
        }

        $sorties = $query->latest()->paginate(15);

        return view('admin.sorties.index', compact('sorties'));
    }

    public function create()
    {
        $unites = Unite::where('actif', true)->get();
        $employes = Employe::where('actif', true)->get();

        return view('admin.sorties.create', compact('unites', 'employes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'unite_id' => 'required|exists:unites,id',
            'employe_id' => 'nullable|exists:employes,id',
            'quantite' => 'required|numeric|min:0.01',
            'nature_sortie' => 'required|in:Consommation interne,Distribution service,Prêt,Casse,Perte,Autre',
        ]);

        // Vérifier le stock disponible
        $verification = Sortie::verifierStock($validated['unite_id'], $validated['quantite']);

        if (!$verification['disponible']) {
            return back()
                ->withInput()
                ->with('error', "Stock insuffisant ! Stock actuel : {$verification['stock_actuel']}, Quantité demandée : {$verification['quantite_demandee']}");
        }

        $validated['user_id'] = auth()->id();
        // code_sortie et numero_bon_decharge seront générés automatiquement

        Sortie::create($validated);

        return redirect()->route(auth()->user()->isAdmin() ? 'admin.sorties.index' : 'user.sorties.index')
            ->with('success', 'Sortie enregistrée avec succès');
    }

    public function show($id)
    {
        $sortie = Sortie::with(['unite', 'employe', 'user'])->findOrFail($id);

        // Vérifier que le user peut voir cette sortie
        if (!auth()->user()->isAdmin() && $sortie->user_id !== auth()->id()) {
            abort(403, 'Accès non autorisé');
        }

        return view('admin.sorties.show', compact('sortie'));
    }

    public function edit($id)
    {
        $sortie = Sortie::findOrFail($id);

        // Vérifier que le user peut modifier cette sortie
        if (!auth()->user()->isAdmin() && $sortie->user_id !== auth()->id()) {
            abort(403, 'Accès non autorisé');
        }

        $unites = Unite::where('actif', true)->get();
        $employes = Employe::where('actif', true)->get();

        return view('admin.sorties.edit', compact('sortie', 'unites', 'employes'));
    }

    public function update(Request $request, $id)
    {
        $sortie = Sortie::findOrFail($id);

        // Vérifier que le user peut modifier cette sortie
        if (!auth()->user()->isAdmin() && $sortie->user_id !== auth()->id()) {
            abort(403, 'Accès non autorisé');
        }

        $validated = $request->validate([
            'unite_id' => 'required|exists:unites,id',
            'employe_id' => 'nullable|exists:employes,id',
            'quantite' => 'required|numeric|min:0.01',
            'nature_sortie' => 'required|in:Consommation interne,Distribution service,Prêt,Casse,Perte,Autre',
        ]);

        // Vérifier le stock (en tenant compte de l'ancienne quantité)
        $verification = Sortie::verifierStock($validated['unite_id'], $validated['quantite'], $id);

        if (!$verification['disponible']) {
            return back()
                ->withInput()
                ->with('error', "Stock insuffisant ! Stock actuel : {$verification['stock_actuel']}, Quantité demandée : {$verification['quantite_demandee']}");
        }

        $sortie->update($validated);

        return redirect()->route(auth()->user()->isAdmin() ? 'admin.sorties.index' : 'user.sorties.index')
            ->with('success', 'Sortie modifiée avec succès');
    }

    public function destroy($id)
    {
        $sortie = Sortie::findOrFail($id);

        // Vérifier que le user peut supprimer cette sortie
        if (!auth()->user()->isAdmin() && $sortie->user_id !== auth()->id()) {
            abort(403, 'Accès non autorisé');
        }

        $sortie->delete();

        return redirect()->route(auth()->user()->isAdmin() ? 'admin.sorties.index' : 'user.sorties.index')
            ->with('success', 'Sortie supprimée avec succès');
    }

    public function generatePDF($id)
    {
        $sortie = Sortie::with(['unite.categorie', 'unite.magasin', 'employe.direction', 'user'])
            ->findOrFail($id);

        // Vérifier que le user peut générer le PDF
        if (!auth()->user()->isAdmin() && $sortie->user_id !== auth()->id()) {
            abort(403, 'Accès non autorisé');
        }

        $pdf = Pdf::loadView('admin.sorties.pdf', compact('sortie'));

        return $pdf->download('fiche-decharge-' . $sortie->numero_bon_decharge . '.pdf');
    }
}
