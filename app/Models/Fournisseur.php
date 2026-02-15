<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fournisseur extends Model
{
    protected $fillable = [
        'nom_fournisseur',
        'code_fournisseur',
        'adresse',
        'telephone',
        'email',
        'actif',
    ];

    protected $casts = [
        'actif' => 'boolean',
    ];


    public function entrees()
    {
        return $this->hasMany(Entree::class);
    }
    // Statistiques
    public function getTotalEntreesAttribute()
    {
        return $this->entrees()->count();
    }

    public function getMontantTotalAttribute()
    {
        return $this->entrees()
            ->selectRaw('SUM(quantite * prix_unit) as total')
            ->value('total') ?? 0;
    }
}
