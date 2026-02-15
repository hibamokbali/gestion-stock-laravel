<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Entree;
use App\Models\Sortie;
use App\Models\Unite;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user_id = auth()->id();
        $debut_mois = now()->startOfMonth();


        // MES STATS DU MOIS

        $stats = [
            'mes_entrees_mois' => Entree::where('user_id', $user_id)
                ->where('created_at', '>=', $debut_mois)
                ->count(),

            'mes_sorties_mois' => Sortie::where('user_id', $user_id)
                ->where('created_at', '>=', $debut_mois)
                ->count(),

            'quantite_entrees' => Entree::where('user_id', $user_id)
                ->where('created_at', '>=', $debut_mois)
                ->sum('quantite'),

            'quantite_sorties' => Sortie::where('user_id', $user_id)
                ->where('created_at', '>=', $debut_mois)
                ->sum('quantite'),

            'total_articles' => Unite::where('actif', true)->count(),
        ];


        // ARTICLES EN ALERTE (VISIBLE PAR USER)

        $tous_articles = Unite::with(['categorie', 'configurationSeuil'])
            ->where('actif', true)
            ->get();

        // Filtrer les articles en alerte
        $articles_alerte = $tous_articles->filter->en_alerte;

        $stats['alertes_stock'] = $articles_alerte->count();

        // Top 5 articles les plus critiques (stock le plus bas)
        $articles_critiques = $articles_alerte
            ->sortBy('stock_actuel')
            ->take(5);


        // MES DERNIÈRES ACTIVITÉS

        $mes_dernieres_entrees = Entree::with('unite')
            ->where('user_id', $user_id)
            ->latest()
            ->take(5)
            ->get();

        $mes_dernieres_sorties = Sortie::with('unite')
            ->where('user_id', $user_id)
            ->latest()
            ->take(5)
            ->get();

        return view('user.dashboard', compact(
            'stats',
            'articles_critiques',
            'mes_dernieres_entrees',
            'mes_dernieres_sorties'
        ));
    }
}
