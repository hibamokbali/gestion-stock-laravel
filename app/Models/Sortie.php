<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sortie extends Model
{
    protected $fillable = [
        'code_sortie',
        'numero_bon_decharge',
        'unite_id',
        'user_id',
        'employe_id',
        'quantite',
        'nature_sortie',
    ];

    protected $casts = [
        'quantite' => 'decimal:2',
    ];

    
    public function unite()
    {
        return $this->belongsTo(Unite::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function employe()
    {
        return $this->belongsTo(Employe::class);
    }

    // Libellés pour nature_sortie
    public function getNatureSortieLibelleAttribute()
    {
        $natures = [
            'Consommation interne' => 'Consommation interne',
            'Distribution service' => 'Distribution service',
            'Prêt' => 'Prêt',
            'Casse' => 'Casse',
            'Perte' => 'Perte',
            'Autre' => 'Autre',
        ];

        return $natures[$this->nature_sortie] ?? $this->nature_sortie;
    }

    // Badge couleur selon nature
    public function getNatureBadgeClassAttribute()
    {
        $badges = [
            'Consommation interne' => 'bg-primary',
            'Distribution service' => 'bg-success',
            'Prêt' => 'bg-info',
            'Casse' => 'bg-danger',
            'Perte' => 'bg-warning',
            'Autre' => 'bg-secondary',
        ];

        return $badges[$this->nature_sortie] ?? 'bg-secondary';
    }

    // Générer automatiquement code et numéro de décharge
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($sortie) {
            if (empty($sortie->code_sortie)) {
                $sortie->code_sortie = self::generateCodeSortie();
            }

            if (empty($sortie->numero_bon_decharge)) {
                $sortie->numero_bon_decharge = self::generateNumeroBonDecharge();
            }
        });
    }

    public static function generateCodeSortie()
    {
        $year = date('Y');
        $month = date('m');

        // Format: SOR-YYYYMM-0001
        $prefix = "SOR-{$year}{$month}-";

        $lastSortie = self::where('code_sortie', 'LIKE', $prefix . '%')
            ->orderBy('code_sortie', 'desc')
            ->first();

        if ($lastSortie) {
            $lastNumber = intval(substr($lastSortie->code_sortie, -4));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    public static function generateNumeroBonDecharge()
    {
        $year = date('Y');

        // Format: BD-YYYY-0001
        $prefix = "BD-{$year}-";

        $lastBon = self::where('numero_bon_decharge', 'LIKE', $prefix . '%')
            ->orderBy('numero_bon_decharge', 'desc')
            ->first();

        if ($lastBon) {
            $lastNumber = intval(substr($lastBon->numero_bon_decharge, -4));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    // Vérifier stock disponible avant création
    public static function verifierStock($unite_id, $quantite, $sortie_id = null)
    {
        $unite = Unite::findOrFail($unite_id);
        $stock_actuel = $unite->stock_actuel;

        // Si c'est une modification, ajouter l'ancienne quantité
        if ($sortie_id) {
            $ancienne_sortie = self::find($sortie_id);
            if ($ancienne_sortie && $ancienne_sortie->unite_id == $unite_id) {
                $stock_actuel += $ancienne_sortie->quantite;
            }
        }

        return [
            'disponible' => $stock_actuel >= $quantite,
            'stock_actuel' => $stock_actuel,
            'quantite_demandee' => $quantite,
            'manquant' => max(0, $quantite - $stock_actuel),
        ];
    }
}
