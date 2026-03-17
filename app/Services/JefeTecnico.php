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

    /**
        * @return \Illuminate\View\View
        * @author Alonso Coronado Alcalde
        * @description  Obtener la media de resolución (duración) de incidencias por técnico
    */
    public function obtenerMediaResolucionPorTecnico($orden = 'asc') {
        $query = DB::table('trabajadores')
            ->leftJoin('incidencias', function($join) {
                $join->on('trabajadores.id', '=', 'incidencias.trabajador_id')
                     ->whereNotNull('incidencias.intervalo_resolucion');
            })
            ->select(
                'trabajadores.id',
                'trabajadores.nombre',
                'trabajadores.apellido',
                DB::raw('ROUND(AVG(incidencias.intervalo_resolucion), 2) as media_resolucion'),
                DB::raw('COUNT(incidencias.id) as incidencias_resueltas')
            )
            ->where('trabajadores.rol', 'tecnico')
            ->groupBy('trabajadores.id', 'trabajadores.nombre', 'trabajadores.apellido');

        if ($orden === 'asc' || $orden === 'desc') {
            $query->orderBy('media_resolucion', $orden);
        }

        return $query->get();
    }
}