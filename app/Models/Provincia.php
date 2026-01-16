<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Provincia extends Model
{
    protected $fillable = [
        'gcd_provincia',
        'nombre'
    ];

    public function islas(): HasMany 
    {
        return $this->hasMany(Isla::class);
    }
}
