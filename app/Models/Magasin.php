<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Magasin extends Model
{
    protected $fillable = [
        'nom_magasin',
        'code_magasin',
        'emplacement',
        'direction_id',
        'actif'
    ];

    protected $casts = [
        'actif' => 'boolean',
    ];

    public function direction()
    {
        return $this->belongsTo(Direction::class);
    }
}
