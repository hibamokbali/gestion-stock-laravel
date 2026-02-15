<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Direction;
use App\Models\Employe;
use App\Models\Entree;
use App\Models\Sortie;
use App\Models\Unite;
use App\Models\User;
use Illuminate\Container\Attributes\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB as FacadesDB;

class DashboardController extends Controller
{
    public function index()
    {
        $debut_mois = now()->startOfMonth();

        // STATS STOCK (LE PLUS IMPORTANT)
  

        $tous_articles = Unite::with('configurationSeuil')
            ->where('actif', true)
            ->get();

        // Articles en alerte (stock <= seuil)
        $articles_alerte = $tous_articles->filter->en_alerte;

        // Articles en rupture (stock = 0)
        $articles_rupture = $tous_articles->filter(function ($article) {
            return $article->stock_actuel <= 0;
        });

        // Articles OK (stock > seuil)
        $articles_ok = $tous_articles->filter(function ($article) {
            return !$article->en_alerte && $article->stock_actuel > 0;
        });

        $stats = [
            'total_articles' => $tous_articles->count(),
            'articles_ok' => $articles_ok->count(),
            'articles_alerte' => $articles_alerte->count(),
            'articles_rupture' => $articles_rupture->count(),
            'alertes_stock' => $articles_alerte->count(),
        ];

        // MOUVEMENTS DU MOIS


        $stats['entrees_mois'] = Entree::where('created_at', '>=', $debut_mois)->count();
        $stats['sorties_mois'] = Sortie::where('created_at', '>=', $debut_mois)->count();

        $stats['quantite_entrees_mois'] = Entree::where('created_at', '>=', $debut_mois)->sum('quantite');
        $stats['quantite_sorties_mois'] = Sortie::where('created_at', '>=', $debut_mois)->sum('quantite');

    
        // ARTICLES CRITIQUES (Top 10 alertes)
      

        $articles_critiques = $articles_alerte
            ->sortBy('stock_actuel')
            ->take(10);

       
        // TOP CONSOMMÉS DU MOIS
      

        $top_consommes = Sortie::with('unite:id,designation,unite_mesure')
            ->where('created_at', '>=', $debut_mois)
            ->selectRaw('unite_id, SUM(quantite) as total')
            ->groupBy('unite_id')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // ACTIVITÉS RÉCENTES
     
        $dernieres_entrees = Entree::with('unite:id,designation', 'user:id,name')
            ->latest()
            ->take(5)
            ->get();

        $dernieres_sorties = Sortie::with('unite:id,designation', 'user:id,name')
            ->latest()
            ->take(5)
            ->get();

        // Infos secondaires
        $stats['total_directions'] = Direction::where('actif', true)->count();
        $stats['total_employes'] = Employe::where('actif', true)->count();

        return view('admin.dashboard', compact(
            'stats',
            'articles_critiques',
            'top_consommes',
            'dernieres_entrees',
            'dernieres_sorties'
        ));
    }
}
