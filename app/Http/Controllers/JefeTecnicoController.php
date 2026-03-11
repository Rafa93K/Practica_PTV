<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\JefeTecnico as JefeTecnicoService;

class JefeTecnicoController extends Controller
{
    protected $jefeTecnicoService;

    public function __construct(JefeTecnicoService $jefeTecnicoService)
    {
        $this->jefeTecnicoService = $jefeTecnicoService;
    }

    public function index(Request $request)
    {
        $incidenciasSinAsignar = $this->jefeTecnicoService->incidenciaSinAsignar();
        $tecnicos = $this->jefeTecnicoService->obtenerTecnicos();

        // Parámetros de filtrado
        $fechaInicio = $request->input('fecha_inicio', date('Y-m-d', strtotime('-1 month')));
        $fechaFin = $request->input('fecha_fin', date('Y-m-d'));
        
        $totalIncidenciasIntervalo = $this->jefeTecnicoService->contarIncidenciasEntreFechas($fechaInicio, $fechaFin);

        return view('jefe_tecnico.inicio', compact(
            'incidenciasSinAsignar', 
            'tecnicos', 
            'totalIncidenciasIntervalo', 
            'fechaInicio', 
            'fechaFin'
        ));
    }

    public function asignarIncidencia(Request $request)
    {
        $request->validate([
            'incidencia_id' => 'required|exists:incidencias,id',
            'trabajador_id' => 'required|exists:trabajadores,id',
            'fecha' => 'required|date',
        ]);

        // Comprobar disponibilidad
        if (!$this->jefeTecnicoService->estaDisponible($request->trabajador_id, $request->fecha)) {
            return redirect()->back()->withErrors(['fecha' => 'El técnico seleccionado ya tiene una incidencia asignada para ese día.']);
        }

        $this->jefeTecnicoService->asignarIncidencia(
            $request->incidencia_id,
            $request->trabajador_id,
            $request->fecha
        );

        return redirect()->back()->with('successTC', 'Incidencia asignada correctamente.');
    }
}
