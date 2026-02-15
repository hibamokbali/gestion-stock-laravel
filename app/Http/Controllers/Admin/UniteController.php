<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
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

    public function destroy($id)
    {
        $unite = Unite::findOrFail($id);

        // Vérifier s'il y a des mouvements de stock
        if ($unite->entrees()->count() > 0 || $unite->sorties()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer cet article car il a des mouvements de stock.');
        }

        $unite->update(['actif' => false]);

        return redirect()->route('admin.unites.index')
            ->with('success', 'Article supprimé avec succès');
    }
}
