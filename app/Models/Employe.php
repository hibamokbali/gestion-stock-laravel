<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employe extends Model
{
    protected $fillable = [
        'matricule',
        'nom',
        'prenom',
        'direction_id',
        'poste',
        'actif'
    ];

    protected $casts = [
        'actif' => 'boolean',
    ];

    public function direction()
    {
        return $this->belongsTo(Direction::class);
    }

    public function getNomCompletAttribute()
    {
        return $this->nom . ' ' . $this->prenom;
    }
}
