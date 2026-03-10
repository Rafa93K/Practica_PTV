<?php

namespace App\Http\Controllers;

use App\Services\ManagerService;
use App\Http\Requests\DynamicRequestValidator;

class ManagerController extends Controller
{
        /**
        * @param ManagerService $managerService
        * @return \Illuminate\View\View
        * @throws 
        * @author Rafael Osuna
        * @description Carga la vista del manager con las estadísticas obtenidas del servicio.
        */
    public function index(DynamicRequestValidator $request, ManagerService $managerService)
    {
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');

        $datos = $managerService->obtenerEstadisticas($fechaInicio, $fechaFin);

        return view('manager.inicio', $datos);
    }
    
}