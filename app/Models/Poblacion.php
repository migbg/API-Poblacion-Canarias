<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Poblacion extends Model
{
    protected $fillable = [
        'nombre',
        'periodo',
        'sexo',
        'edad',
        'cantidad',
        'codigo_municipio'
    ];

    public function municipio(): BelongsTo 
    {
        return $this->belongsTo(Municipio::class, 'codigo_municipio', 'codigo');
    }
}
