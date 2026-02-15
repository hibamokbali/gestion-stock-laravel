<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    protected $fillable = ['libelle', 'code_categorie', 'actif'];

    protected $casts = [
        'actif' => 'boolean',
    ];
}
