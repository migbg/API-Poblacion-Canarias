<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Isla extends Model
{
    protected $fillable = [
        'gcd_isla',
        'nombre',
        'gcd_provincia',
    ];

    public function provincia(): BelongsTo 
    {
        return $this->belongsTo(Provincia::class);
    }

    public function municipios(): HasMany
    {
        return $this->hasMany(Municipio::class);
    }
}
