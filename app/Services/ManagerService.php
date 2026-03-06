<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class ManagerService
{
    /**
     * @param none
     * @return array  
     * @throws 
     * @author Rafael Osuna
     * @description Obtenemos los datos de las tablas para devolver la informacion al manager.
     */
   public function obtenerEstadisticas()
    {
        $totalContratos = DB::table('contratos')->count();

        $totalIncidencias = DB::table('incidencias')->count();

        $producido = DB::table('facturas')->sum('precio');

        $invertido = DB::table('productos')->selectRaw('SUM(cantidad * precio) as total')->value('total');

        $beneficio = $producido - $invertido;

        // Obtener el estado de las incidencias
        $abierto = DB::table('incidencias')->where('estado', 'abierto')->count();
        $en_proceso = DB::table('incidencias')->where('estado', 'en_proceso')->count();
        $cerrado=DB::table('incidencias')->where('estado','cerrado')->count();

        return [
            'totalContratos' => $totalContratos,
            'totalIncidencias' => $totalIncidencias,
            'producido' => $producido,
            'invertido' => $invertido,
            'beneficio' => $beneficio,
            'abierto' => $abierto,
            'en_proceso' => $en_proceso,
            'cerrado'=> $cerrado
        ];
    }
}


?>