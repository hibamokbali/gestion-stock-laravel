<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Categorie::where('actif', true)->latest()->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'libelle' => 'required|string|max:255',
            'code_categorie' => 'required|string|unique:categories',
        ]);

        Categorie::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Catégorie créée avec succès');
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
        $categorie = Categorie::findOrFail($id);
        return view('admin.categories.edit', compact('categorie'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $categorie = Categorie::findOrFail($id);

        $validated = $request->validate([
            'libelle' => 'required|string|max:255',
            'code_categorie' => 'required|string|unique:categories,code_categorie,' . $id,
        ]);

        $categorie->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Catégorie modifiée avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categorie $categorie)
    {
        try {
            // Vérifier s'il y a des articles liés
            $articles_count = \App\Models\Unite::where('categorie_id', $categorie->id)->count();

            if ($articles_count > 0) {
                return redirect()->route('admin.categories.index')
                    ->with('error', "Impossible de supprimer cette catégorie : {$articles_count} article(s) y appartiennent.");
            }

            // Suppression réelle
            $categorie->delete();

            return redirect()->route('admin.categories.index')
                ->with('success', 'Catégorie supprimée définitivement avec succès');
        } catch (\Exception $e) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Erreur lors de la suppression : ' . $e->getMessage());
        }
    }
}
