<?php

namespace App\Http\Controllers;

use App\Http\Requests\DynamicRequestValidator;
use App\Services\TecnicoService;

class TecnicoController extends Controller {
    private TecnicoService $tecnicoService;

    /**
     * @param TecnicoService $tecnicoService
     * @author Alonso Coronado Alcalde
     * @description Inyecta el servicio de cliente.
     */
    public function __construct(TecnicoService $tecnicoService) {
        $this->tecnicoService = $tecnicoService;
    }

    /**
     * @param DynamicRequestValidator $request
     * @return \Illuminate\View\View
     * @author Alonso Coronado Alcalde
     * @description Muestra el panel del técnico con sus incidencias asignadas y estadísticas.
     */
    public function index(DynamicRequestValidator $request) {
        $tecnicoId = session('user_id');

        //Estadisticas generales
        $totalIncidencias = $this->tecnicoService->getTotalIncidencias($tecnicoId);
        $pendienteTotal = $this->tecnicoService->getIncidenciasAbiertas($tecnicoId);
        $en_procesoTotal = $this->tecnicoService->getIncidenciasEnProgreso($tecnicoId);
        $cerradoTotal = $this->tecnicoService->getIncidenciasCerradas($tecnicoId);

        //Total clientes atendidos
        $totalClientes = $this->tecnicoService->getTotalClientes($tecnicoId);

        //Incidencias asignadas (no cerradas) - Estas siempre se muestran
        $incidenciasAsignadas = $this->tecnicoService->getIncidenciasAsignadas($tecnicoId);

        //Filtro por intervalo
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');

        $incidenciasResueltas = $this->tecnicoService->getIncidenciasResueltas($tecnicoId, $fechaInicio, $fechaFin);

        //Datos para el gráfico del historial
        if ($fechaInicio && $fechaFin) {
            $pendiente = $this->tecnicoService->getEstadisticasPeriodo($tecnicoId, $fechaInicio, $fechaFin)['pendiente'];
            $en_proceso = $this->tecnicoService->getEstadisticasPeriodo($tecnicoId, $fechaInicio, $fechaFin)['en_proceso'];
            $cerrado = count($incidenciasResueltas);
        } else {
            $pendiente = $pendienteTotal;
            $en_proceso = $en_procesoTotal;
            $cerrado = $cerradoTotal;
        }

        //Enviamos los datos al inicio
        return view('tecnico.inicio', compact(
            'totalIncidencias', 'pendienteTotal', 'en_procesoTotal', 'cerradoTotal', 'totalClientes',
            'pendiente', 'en_proceso', 'cerrado', 
            'incidenciasAsignadas', 'incidenciasResueltas', 'fechaInicio', 'fechaFin'
        ));
    }

    /**
     * @param DynamicRequestValidator $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @author Alonso Coronado Alcalde
     * @description Actualiza el estado de una incidencia.
     */
    public function actualizarEstado(DynamicRequestValidator $request, $id) {
        $tecnicoId = session('user_id');
        $estado = $request->input('estado');

        //Comprueba que el usuario que intenta acceder es un técnico
        $this->tecnicoService->comprobarTecnico($request);

        //Actualiza el estado de la incidencia
        $this->tecnicoService->actualizarEstado($tecnicoId, $id, $estado);

        return back()->with('success', 'Estado de la incidencia actualizado correctamente.');
    }
}