<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['type', 'actif'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
