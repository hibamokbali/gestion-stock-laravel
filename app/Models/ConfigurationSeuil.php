<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfigurationSeuil extends Model
{
    protected $table = 'configuration_seuils';

    protected $fillable = [
        'unite_id',
        'valeur_alerte',
        'actif',
    ];

    protected $casts = [
        'valeur_alerte' => 'decimal:2',
        'actif' => 'boolean',
    ];

    
    public function unite()
    {
        return $this->belongsTo(Unite::class);
    }
}
