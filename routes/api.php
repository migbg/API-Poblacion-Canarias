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

Route::get('municipios', [ApiController::class, 'municipios']);
Route::get('islas', [ApiController::class, 'islas']);