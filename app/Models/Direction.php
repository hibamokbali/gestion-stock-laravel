<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Direction extends Model
{
    protected $fillable = ['nom_direction', 'code_direction', 'actif'];

    protected $casts = [
        'actif' => 'boolean',
    ];

    public function magasins()
    {
        return $this->hasMany(Magasin::class);
    }

    public function employes()
    {
        return $this->hasMany(Employe::class);
    }
}
