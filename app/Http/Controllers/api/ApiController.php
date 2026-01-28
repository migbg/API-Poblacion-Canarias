<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MunicipiosRequest;
use App\Models\Poblacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function municipios(MunicipiosRequest $request)
    {

        // if (!$request->municipio) {
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'El parámetro municipio es obligatorio'
        //     ]);
        // }

        $query = Poblacion::join('municipios', 'poblacions.codigo_municipio', '=', 'municipios.codigo')
            ->where('municipios.nombre', $request->municipio);

        if ($request->sexo) {
            $query->where('poblacions.sexo', $request->sexo);
        }

        if ($request->periodo) {
            $query->where('poblacions.periodo', $request->periodo);
        } else {
            $query->where('poblacions.periodo', 2025);
        }

        if ($request->edad) {
            $query->where('poblacions.edad', $request->edad);
        }

        if ($request->edad_min && $request->edad_max && !$request->edad) {
            $query->whereBetween('poblacions.edad', [$request->edad_min, $request->edad_max]);
        } elseif ($request->edad_min) {
            $query->where('poblacions.edad', '>=', $request->edad_min);
        } elseif ($request->edad_max) {
            $query->where('poblacions.edad', '<=', $request->edad_max);
        }

        if (!$query->exists()) {
            return response()->json([
                'status' => 'ok',
                'message' => 'No se encontraron datos para los filtros especificados',
            ]);
        }

        $resultado = $query->sum('cantidad');

        return response()->json([
            'status' => 'ok',
            'message' => 'Datos de población de ' . strtoupper($request->municipio),
            'quantity' => $resultado
        ]);
    }
}