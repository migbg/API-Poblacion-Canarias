<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Municipio extends Model
{
    protected $fillable = [
        'codigo',
        'nombre',
        'gcd_isla',
    ];

    public function isla(): BelongsTo 
    {
        return $this->belongsTo(Isla::class);
    }

    public function poblaciones(): HasMany
    {
        return $this->hasMany(Poblacion::class);
    }
}
