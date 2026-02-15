<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entree extends Model
{

    protected $fillable = [
        'code_entree',
        'unite_id',
        'user_id',
        'fournisseur_id',
        'quantite',
        'date_reception',
        'numero_bon',
        'numero_facture',
        'prix_unit',
    ];

    protected $casts = [
        'date_reception' => 'date',
        'quantite' => 'decimal:2',
        'prix_unit' => 'decimal:2',
    ];

    // Relations
    public function unite()
    {
        return $this->belongsTo(Unite::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class);
    }

    // Attributs calculés
    public function getMontantTotalAttribute()
    {
        return $this->quantite * ($this->prix_unit ?? 0);
    }

    // Générer automatiquement un code d'entrée
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($entree) {
            if (empty($entree->code_entree)) {
                $entree->code_entree = self::generateCodeEntree();
            }
        });
    }

    public static function generateCodeEntree()
    {
        $year = date('Y');
        $month = date('m');

        // Format: ENT-YYYYMM-0001
        $prefix = "ENT-{$year}{$month}-";

        $lastEntree = self::where('code_entree', 'LIKE', $prefix . '%')
            ->orderBy('code_entree', 'desc')
            ->first();

        if ($lastEntree) {
            $lastNumber = intval(substr($lastEntree->code_entree, -4));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }
}
