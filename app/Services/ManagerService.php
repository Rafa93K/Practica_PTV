<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class ManagerService {
    /**
     * @param $fechaInicio
     * @param $fechaFin
     * @return array  
     * @throws 
     * @author Rafael Osuna
     * @description Obtenemos los datos de las tablas para devolver la informacion al manager.
     */
    public function obtenerEstadisticas($fechaInicio = null, $fechaFin = null) {
        $queryContratos = DB::table('contratos');
        $queryIncidencias = DB::table('incidencias');
        $queryFacturas = DB::table('facturas');
        $queryProductos = DB::table('productos');

        if ($fechaInicio) {
            $queryContratos->where('created_at', '>=', $fechaInicio);
            $queryIncidencias->where('created_at', '>=', $fechaInicio);
            $queryFacturas->where('created_at', '>=', $fechaInicio);
            $queryProductos->where('created_at', '>=', $fechaInicio);
        }

        if ($fechaFin) {
            $queryContratos->where('created_at', '<=', $fechaFin . ' 23:59:59');
            $queryIncidencias->where('created_at', '<=', $fechaFin . ' 23:59:59');
            $queryFacturas->where('created_at', '<=', $fechaFin . ' 23:59:59');
            $queryProductos->where('created_at', '<=', $fechaFin . ' 23:59:59');
        }

        $totalContratos = $queryContratos->count();
        $totalIncidencias = $queryIncidencias->count();
        $producido = $queryFacturas->sum('precio');
        $invertido = $queryProductos->selectRaw('SUM(cantidad * precio) as total')->value('total') ?? 0;
        $beneficio = $producido - $invertido;

        // Obtener el estado de las incidencias (usando una copia de la query de incidencias para mantener los filtros)
        $pendiente = (clone $queryIncidencias)->where('estado', 'pendiente')->count();
        $en_proceso = (clone $queryIncidencias)->where('estado', 'en_progreso')->count();
        $cerrado = (clone $queryIncidencias)->where('estado', 'cerrado')->count();

        return [
            'totalContratos' => $totalContratos,
            'totalIncidencias' => $totalIncidencias,
            'producido' => $producido,
            'invertido' => $invertido,
            'beneficio' => $beneficio,
            'pendiente' => $pendiente,
            'en_proceso' => $en_proceso,
            'cerrado' => $cerrado,
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin
        ];
    }
}