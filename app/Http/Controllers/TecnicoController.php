<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TecnicoController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\View\View
     * @author Alonso Coronado Alcalde
     * @description Muestra el panel del técnico con sus incidencias asignadas y estadísticas.
     */
    public function index(Request $request)
    {
        $tecnicoId = session('user_id');

        // Estadísticas generales para el técnico (Tarjetas superiores - Siempre muestran el total)
        $totalIncidencias = DB::table('incidencias')->where('trabajador_id', $tecnicoId)->count();
        $abiertoTotal = DB::table('incidencias')->where('trabajador_id', $tecnicoId)->where('estado', 'abierto')->count();
        $en_procesoTotal = DB::table('incidencias')->where('trabajador_id', $tecnicoId)->where('estado', 'en_progreso')->count();
        $cerradoTotal = DB::table('incidencias')->where('trabajador_id', $tecnicoId)->where('estado', 'cerrado')->count();

        // Total clientes atendidos
        $totalClientes = DB::table('incidencias')
            ->where('trabajador_id', $tecnicoId)
            ->distinct('cliente_id')
            ->count('cliente_id');

        // Incidencias asignadas (no cerradas) - Estas siempre se muestran
        $incidenciasAsignadas = DB::table('incidencias')
            ->join('clientes', 'incidencias.cliente_id', '=', 'clientes.id')
            ->select('incidencias.*', 'clientes.nombre as cliente_nombre', 'clientes.apellido as cliente_apellido')
            ->where('incidencias.trabajador_id', $tecnicoId)
            ->where('incidencias.estado', '!=', 'cerrado')
            ->orderBy('incidencias.fecha', 'desc')
            ->get();

        // --- FILTRO POR INTERVALO (Para el Historial y el Gráfico Integrado) ---
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');

        $queryResueltas = DB::table('incidencias')
            ->join('clientes', 'incidencias.cliente_id', '=', 'clientes.id')
            ->select('incidencias.*', 'clientes.nombre as cliente_nombre', 'clientes.apellido as cliente_apellido')
            ->where('incidencias.trabajador_id', $tecnicoId)
            ->where('incidencias.estado', 'cerrado');

        // Si hay fechas, filtramos las resueltas por el intervalo
        if ($fechaInicio && $fechaFin) {
            $queryResueltas->whereBetween('updated_at', [$fechaInicio . ' 00:00:00', $fechaFin . ' 23:59:59']);
        }

        $incidenciasResueltas = $queryResueltas->orderBy('updated_at', 'desc')->get();

        // Datos para el gráfico del HISTORIAL (Representa lo que ha pasado en ese intervalo si se filtra, o el global si no)
        // Decidimos que el gráfico en esta sección represente el éxito del técnico en el periodo
        if ($fechaInicio && $fechaFin) {
            $abierto = DB::table('incidencias')->where('trabajador_id', $tecnicoId)->where('estado', 'abierto')->whereBetween('created_at', [$fechaInicio, $fechaFin])->count();
            $en_proceso = DB::table('incidencias')->where('trabajador_id', $tecnicoId)->where('estado', 'en_progreso')->whereBetween('updated_at', [$fechaInicio, $fechaFin])->count();
            $cerrado = count($incidenciasResueltas);
        } else {
            $abierto = $abiertoTotal;
            $en_proceso = $en_procesoTotal;
            $cerrado = $cerradoTotal;
        }

        return view('tecnico.inicio', compact(
            'totalIncidencias', 'abiertoTotal', 'en_procesoTotal', 'cerradoTotal', 'totalClientes',
            'abierto', 'en_proceso', 'cerrado', 
            'incidenciasAsignadas', 'incidenciasResueltas', 'fechaInicio', 'fechaFin'
        ));
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @author Alonso Coronado Alcalde
     * @description Actualiza el estado de una incidencia.
     */
    public function actualizarEstado(Request $request, $id)
    {
        $tecnicoId = session('user_id');
        $estado = $request->input('estado');

        DB::table('incidencias')
            ->where('id', $id)
            ->where('trabajador_id', $tecnicoId)
            ->update([
                'estado' => $estado,
                'updated_at' => now()
            ]);

        return back()->with('success', 'Estado de la incidencia actualizado correctamente.');
    }
}