<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\IslasRequest;
use App\Http\Requests\MunicipiosRequest;
use App\Models\Isla;
use App\Models\Municipio;
use App\Models\Poblacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function municipios(MunicipiosRequest $request)
    {
        $query = Poblacion::join('municipios', 'poblacions.codigo_municipio', '=', 'municipios.codigo')
            ->where('municipios.nombre', $request->nombre);

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
            'message' => 'Datos de población de ' . strtoupper($request->nombre),
            'quantity' => $resultado
        ]);
    }

    public function islas(IslasRequest $request)
    {
        $query = Poblacion::join('municipios', 'poblacions.codigo_municipio', '=', 'municipios.codigo')
            ->join('islas', 'municipios.gcd_isla', '=', 'islas.gcd_isla')
            ->where('islas.nombre', $request->nombre);
        
        if ($request->sexo) {
            $query->where('poblacions.sexo', strtoupper($request->sexo));
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
        
        if ($request->desglosado) {
            $resultado = $query
                ->select('municipios.nombre as municipio')
                ->selectRaw('SUM(poblacions.cantidad) as quantity')
                ->groupBy('municipios.nombre')
                ->orderBy('municipios.nombre')
                ->get();
            
            return response()->json([
                'status' => 'ok',
                'message' => 'Datos de población de ' . strtoupper($request->nombre) . ' desglosados por municipio',
                'data' => $resultado
            ]);
        } else {
            $resultado = $query->sum('poblacions.cantidad');
            
            return response()->json([
                'status' => 'ok',
                'message' => 'Datos de población de ' . strtoupper($request->nombre),
                'quantity' => $resultado
            ]);
        }
    }

    public function buscar(Request $request)
    {
        $municipios = Municipio::select('nombre')->where('nombre', 'like', '%' . $request->nombre . '%')
            ->orderBy('nombre')
            ->pluck('nombre');
        $islas = Isla::select('nombre')->where('nombre', 'like', '%' . $request->nombre . '%')
            ->orderBy('nombre')
            ->pluck('nombre');

        if ($request->nombre) {
            return response()->json([
                'status' => 'ok',
                'message' => 'Datos sobre la búsqueda',
                'muncipios' => $municipios,
                'islas' => $islas
            ]);
        } else {
            return response()->json([
                'status' => 'ok',
                'message' => 'Especifica un nombre en la busqueda'
            ]);
        }
    }
}