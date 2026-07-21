<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unite extends Model
{
    protected $fillable = [
        'code_unite',
        'designation',
        'unite_mesure',
        'categorie_id',
        'magasin_id',
        'actif',
    ];

    protected $casts = [
        'actif' => 'boolean',
    ];

    protected $appends = ['stock_actuel', 'en_alerte'];


    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function magasin()
    {
        return $this->belongsTo(Magasin::class);
    }

    public function entrees()
    {
        return $this->hasMany(Entree::class);
    }

    public function sorties()
    {
        return $this->hasMany(Sortie::class);
    }

    public function configurationSeuil()
    {
        return $this->hasOne(ConfigurationSeuil::class);
    }

    // Attributs calculés
    public function getStockActuelAttribute()
    {
        $total_entrees = $this->entrees()->sum('quantite');
        $total_sorties = $this->sorties()->sum('quantite');

        return $total_entrees - $total_sorties;
    }

    public function getSeuilAlerteAttribute()
    {
        return $this->configurationSeuil?->valeur_alerte ?? 0;
    }

    public function getEnAlerteAttribute()
    {
        $stock = $this->stock_actuel;
        $seuil = $this->seuil_alerte;

        return $stock > 0 && $stock <= $seuil && $seuil > 0;
    }

    public function getPrixMoyenAttribute()
    {
        $total_entrees = $this->entrees()->sum('quantite');

        if ($total_entrees == 0) {
            return 0;
        }

        $cout_total = $this->entrees()
            ->selectRaw('SUM(quantite * prix_unit) as total')
            ->value('total');

        return $cout_total / $total_entrees;
    }


    // Historique des mouvements
    // Dernières entrées uniquement
    public function dernieres_entrees($limit = 5)
    {
        return $this->entrees()
            ->with('fournisseur', 'user')
            ->latest()
            ->limit($limit)
            ->get();
    }

    // Dernières sorties uniquement
    public function dernieres_sorties($limit = 5)
    {
        return $this->sorties()
            ->with('employe', 'user')
            ->latest()
            ->limit($limit)
            ->get();
    }

    // Historique complet (fusion dans la vue ou contrôleur)
    public function historique_complet($limit = 10)
    {
        $entrees = $this->dernieres_entrees($limit);
        $sorties = $this->dernieres_sorties($limit);

        return [
            'entrees' => $entrees,
            'sorties' => $sorties,
        ];
    }
    // Nombre total d'entrées
    public function getTotalEntreesAttribute()
    {
        return $this->entrees()->count();
    }

    // Nombre total de sorties
    public function getTotalSortiesAttribute()
    {
        return $this->sorties()->count();
    }

    // Valeur du stock (quantité × prix moyen)
    public function getValeurStockAttribute()
    {
        return $this->stock_actuel * $this->prix_moyen;
    }

    public function calculerStockActuel()
    {
        return $this->stock_actuel;
    }

    public function estEnAlerte()
    {
        return $this->en_alerte;  // Utilise l'accessor
    }

    public function estEnRupture()
    {
        return $this->stock_actuel <= 0;
    }
}
