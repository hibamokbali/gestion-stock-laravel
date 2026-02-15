<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\Magasin;
use App\Models\Unite;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Unite::with(['categorie', 'magasin', 'configurationSeuil'])
            ->where('actif', true);

        // Filtres
        if ($request->filled('categorie_id')) {
            $query->where('categorie_id', $request->categorie_id);
        }

        if ($request->filled('magasin_id')) {
            $query->where('magasin_id', $request->magasin_id);
        }

        if ($request->filled('alerte') && $request->alerte == '1') {
            // Filtrer uniquement les articles en alerte
            $query->whereHas('configurationSeuil', function ($q) {
                $q->whereRaw('(
                    SELECT COALESCE(SUM(quantite), 0) FROM entrees WHERE unite_id = unites.id
                ) - (
                    SELECT COALESCE(SUM(quantite), 0) FROM sorties WHERE unite_id = unites.id
                ) <= valeur_alerte');
            });
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('code_unite', 'LIKE', "%{$search}%")
                    ->orWhere('designation', 'LIKE', "%{$search}%");
            });
        }

        $unites = $query->latest()->paginate(20);

        // Pour les filtres
        $categories = Categorie::where('actif', true)->get();
        $magasins = Magasin::where('actif', true)->get();

        return view('admin.stock.index', compact('unites', 'categories', 'magasins'));
    }
}
