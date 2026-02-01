<?php

use App\Http\Controllers\api\ApiController;
use App\Http\Controllers\api\MunicipiosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/status', function(){
    return response()->json([
        'status' => 'ok',
        'laravel' => app()->version()
    ]);
});

# Para peticiones añadir header de Accept:application/json
Route::get('municipio', [ApiController::class, 'municipios']);
Route::get('isla', [ApiController::class, 'islas']);
Route::get('buscar', [ApiController::class, 'buscar']);