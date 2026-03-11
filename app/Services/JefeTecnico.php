<?php


namespace App\Services;
use Illuminate\Support\Facades\DB;

class JefeTecnico
{
    /**
        * @return \Illuminate\View\View
        * @throws 
        * @author Rafael Osuna
        * @description  Devuelve las incidencias que no tengan asignado id de tecnico
    */
    public function incidenciaSinAsignar()
    {
        $incidencias = DB::table('incidencias')
            ->where('trabajador_id', null)
            ->get();
        return $incidencias; 
    }

    /**
     * Obtener todos los trabajadores con rol 'tecnico'
     */
    public function obtenerTecnicos()
    {
        return DB::table('trabajadores')
            ->where('rol', 'tecnico')
            ->get();
    }

    /**
     * Comprobar si un técnico ya tiene una incidencia asignada en una fecha determinada
     */
    public function estaDisponible($trabajadorId, $fecha)
    {
        $existe = DB::table('incidencias')
            ->where('trabajador_id', $trabajadorId)
            ->whereDate('fecha_inicio', $fecha)
            ->exists();
            
        return !$existe;
    }

    /**
     * Asignar una incidencia a un trabajador y establecer fecha
     */
    public function asignarIncidencia($incidenciaId, $trabajadorId, $fecha)
    {
        return DB::table('incidencias')
            ->where('id', $incidenciaId)
            ->update([
                'trabajador_id' => $trabajadorId, 
                'fecha_inicio' => $fecha,
                'estado' => 'pendiente'
            ]);
    }

    /**
     * Contar incidencias creadas entre dos fechas
     */
    public function contarIncidenciasEntreFechas($fechaInicio, $fechaFin)
    {
        return DB::table('incidencias')
            ->whereBetween('created_at', [$fechaInicio . ' 00:00:00', $fechaFin . ' 23:59:59'])
            ->count();
    }
}

