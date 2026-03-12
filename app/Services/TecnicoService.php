<?php

namespace App\Services;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\DynamicRequestValidator;

class TecnicoService {
    /**
     * @param DynamicRequestValidator $request
     * @return int
     * @throws \Illuminate\Validation\ValidationException
     * @author Alonso Coronado Alcalde
     * @description Comprueba que el usuario que intenta acceder es un técnico.
     */
    public function comprobarTecnico(DynamicRequestValidator $request) {
        //Comprueba que el usuario que intenta acceder es un técnico
        $tecnicoId = session('user_id');
        $userType = session('user_type');

        //Si no es un técnico o no existe, lo devolvemos a la pagina de login
        if (!$tecnicoId || $userType !== 'tecnico') {
            return redirect()->route('login', 'tecnico')->withErrors(['email' => 'Debes iniciar sesion como técnico']);
        }

        return $tecnicoId; //Devolvemos el ID del técnico
    }
    
    /**
     * @param int $tecnicoId
     * @return int
     * @author Alonso Coronado Alcalde
     * @description Obtiene el número total de incidencias asignadas al técnico.
     */
    public function getTotalIncidencias($tecnicoId): int {
        return DB::table('incidencias')->where('trabajador_id', $tecnicoId)->count();
    }
    
    /**
     * @param int $tecnicoId
     * @return int
     * @author Alonso Coronado Alcalde
     * @description Obtiene el número de incidencias abiertas asignadas al técnico.
     */
    public function getIncidenciasAbiertas($tecnicoId): int {
        return DB::table('incidencias')->where('trabajador_id', $tecnicoId)->where('estado', 'pendiente')->count();
    }
    
    /**
     * @param int $tecnicoId
     * @return int
     * @author Alonso Coronado Alcalde
     * @description Obtiene el número de incidencias en progreso asignadas al técnico.
     */
    public function getIncidenciasEnProgreso($tecnicoId): int {
        return DB::table('incidencias')->where('trabajador_id', $tecnicoId)->where('estado', 'en_proceso')->count();
    }
    
    /**
     * @param int $tecnicoId
     * @return int
     * @author Alonso Coronado Alcalde
     * @description Obtiene el número de incidencias cerradas asignadas al técnico.
     */
    public function getIncidenciasCerradas($tecnicoId): int {
        return DB::table('incidencias')->where('trabajador_id', $tecnicoId)->where('estado', 'cerrado')->count();
    }
    
    /**
     * @param int $tecnicoId
     * @return int
     * @author Alonso Coronado Alcalde
     * @description Obtiene el número total de clientes atendidos por el técnico.
     */
    public function getTotalClientes($tecnicoId): int {
        return DB::table('incidencias')->where('trabajador_id', $tecnicoId)->distinct('cliente_id')->count('cliente_id');
    }
    
    /**
     * @param int $tecnicoId
     * @return \Illuminate\Support\Collection
     * @author Alonso Coronado Alcalde
     * @description Obtiene las incidencias asignadas al técnico (no cerradas).
     */
    public function getIncidenciasAsignadas($tecnicoId) {
        return DB::table('incidencias')
            ->join('clientes', 'incidencias.cliente_id', '=', 'clientes.id')
            ->select('incidencias.*', 'clientes.nombre as cliente_nombre', 'clientes.apellido as cliente_apellido')
            ->where('incidencias.trabajador_id', $tecnicoId)
            ->where('incidencias.estado', '!=', 'cerrado')
            ->orderBy('incidencias.fecha_inicio', 'desc')
            ->get();
    }
    
    /**
     * @param int $tecnicoId
     * @param string $fechaInicio
     * @param string $fechaFin
     * @return \Illuminate\Support\Collection
     * @author Alonso Coronado Alcalde
     * @description Obtiene las incidencias resueltas por el técnico en un periodo determinado.
     */
    public function getIncidenciasResueltas($tecnicoId, $fechaInicio, $fechaFin) {
        return DB::table('incidencias')
            ->join('clientes', 'incidencias.cliente_id', '=', 'clientes.id')
            ->select('incidencias.*', 'clientes.nombre as cliente_nombre', 'clientes.apellido as cliente_apellido')
            ->where('incidencias.trabajador_id', $tecnicoId)
            ->where('incidencias.estado', 'cerrado')
            ->whereBetween('incidencias.updated_at', [$fechaInicio . ' 00:00:00', $fechaFin . ' 23:59:59'])
            ->orderBy('incidencias.updated_at', 'desc')
            ->get();
    }
    
    /**
     * @param int $tecnicoId
     * @param string $fechaInicio
     * @param string $fechaFin
     * @return array
     * @author Alonso Coronado Alcalde
     * @description Obtiene las estadísticas de incidencias por estado en un periodo determinado.
     */
    public function getEstadisticasPeriodo($tecnicoId, $fechaInicio, $fechaFin): array {
        $pendiente = DB::table('incidencias')->where('trabajador_id', $tecnicoId)->where('estado', 'pendiente')->whereBetween('created_at', [$fechaInicio, $fechaFin])->count();
        $en_proceso = DB::table('incidencias')->where('trabajador_id', $tecnicoId)->where('estado', 'en_proceso')->whereBetween('updated_at', [$fechaInicio, $fechaFin])->count();
        $cerrado = DB::table('incidencias')->where('trabajador_id', $tecnicoId)->where('estado', 'cerrado')->whereBetween('updated_at', [$fechaInicio, $fechaFin])->count();
        
        return [
            'pendiente' => $pendiente,
            'en_proceso' => $en_proceso,
            'cerrado' => $cerrado
        ];
    }
    
    /**
     * @param int $tecnicoId
     * @param int $incidenciaId
     * @param string $estado
     * @return bool
     * @author Alonso Coronado Alcalde
     * @description Actualiza el estado de una incidencia.
     */
    public function actualizarEstado($tecnicoId, $incidenciaId, $estado): bool {
        $ahora = now();
        $data = [
            'estado' => $estado,
            'updated_at' => $ahora
        ];

        if ($estado === 'en_proceso') {
            $data['fecha_inicio'] = $ahora;
        } elseif ($estado === 'cerrado') {
            $data['fecha_fin'] = $ahora;
            
            // Calcular intervalo_resolucion si existe fecha_inicio
            $incidencia = DB::table('incidencias')->where('id', $incidenciaId)->first();
            if ($incidencia && $incidencia->fecha_inicio) {
                $inicio = \Carbon\Carbon::parse($incidencia->fecha_inicio);
                $data['intervalo_resolucion'] = $inicio->diffInMinutes($ahora);
            }
        }

        return DB::table('incidencias')
            ->where('id', $incidenciaId)
            ->where('trabajador_id', $tecnicoId)
            ->update($data);
    }
}