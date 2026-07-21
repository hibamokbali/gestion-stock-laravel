<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\ConfigurationSeuil;
use App\Models\Magasin;
use App\Models\Unite;
use Illuminate\Http\Request;

class UniteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $unites = Unite::with(['categorie', 'magasin'])
            ->where('actif', true)
            ->latest()
            ->paginate(15);

        return view('admin.unites.index', compact('unites'));
    }

    public function create()
    {
        $categories = Categorie::where('actif', true)->get();
        $magasins = Magasin::where('actif', true)->get();

        return view('admin.unites.create', compact('categories', 'magasins'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code_unite' => 'required|string|unique:unites',
            'designation' => 'required|string|max:255',
            'unite_mesure' => 'required|in:pièce,boîte,paquet,rame,kg,g,litre,ml,mètre,cm,lot,rouleau,carton,sachet,flacon,tube',
            'categorie_id' => 'required|exists:categories,id',
            'magasin_id' => 'required|exists:magasins,id',
        ]);

        Unite::create($validated);

        return redirect()->route('admin.unites.index')
            ->with('success', 'Article créé avec succès');
    }

    public function show($id)
    {
        $unite = Unite::with([
            'categorie',
            'magasin',
            'configurationSeuil',
            'entrees' => function ($query) {
                $query->latest()->limit(10);
            },
            'sorties' => function ($query) {
                $query->latest()->limit(10);
            }
        ])->findOrFail($id);

        return view('admin.unites.show', compact('unite'));
    }

    public function edit($id)
    {
        $unite = Unite::findOrFail($id);
        $categories = Categorie::where('actif', true)->get();
        $magasins = Magasin::where('actif', true)->get();

        return view('admin.unites.edit', compact('unite', 'categories', 'magasins'));
    }

    public function update(Request $request, $id)
    {
        $unite = Unite::findOrFail($id);

        $validated = $request->validate([
            'code_unite' => 'required|string|unique:unites,code_unite,' . $id,
            'designation' => 'required|string|max:255',
            'unite_mesure' => 'required|in:pièce,boîte,paquet,rame,kg,g,litre,ml,mètre,cm,lot,rouleau,carton,sachet,flacon,tube',
            'categorie_id' => 'required|exists:categories,id',
            'magasin_id' => 'required|exists:magasins,id',
        ]);

        $unite->update($validated);

        return redirect()->route('admin.unites.index')
            ->with('success', 'Article modifié avec succès');
    }

    public function destroy(Unite $unite)
    {
        try {
            // Vérifier s'il y a des entrées liées
            $entrees_count = \App\Models\Entree::where('unite_id', $unite->id)->count();

            // Vérifier s'il y a des sorties liées
            $sorties_count = \App\Models\Sortie::where('unite_id', $unite->id)->count();

            $total_mouvements = $entrees_count + $sorties_count;

            if ($total_mouvements > 0) {
                return redirect()->route('admin.unites.index')
                    ->with('error', "Impossible de supprimer cet article : {$entrees_count} entrée(s) et {$sorties_count} sortie(s) existent.");
            }

            // Supprimer la configuration de seuil si elle existe
            \App\Models\ConfigurationSeuil::where('unite_id', $unite->id)->delete();

            // Suppression réelle
            $unite->delete();

            return redirect()->route('admin.unites.index')
                ->with('success', 'Article supprimé définitivement avec succès');
        } catch (\Exception $e) {
            return redirect()->route('admin.unites.index')
                ->with('error', 'Erreur lors de la suppression : ' . $e->getMessage());
        }
    }
    // Dans UniteController.php
public function configurerSeuil(Request $request, Unite $unite)
{
    $validated = $request->validate([
        'seuil' => 'required|numeric|min:0'
    ]);

    ConfigurationSeuil::updateOrCreate(
        ['unite_id' => $unite->id],  
        [
            'valeur_alerte' => $validated['seuil'],
            'actif' => true
        ]
    );

    return back()->with('success', 'Seuil configuré');

    }
}
