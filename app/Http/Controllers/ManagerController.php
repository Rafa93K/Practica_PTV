<?php

namespace App\Http\Controllers;

use App\Services\ManagerService;

class ManagerController extends Controller
{
        /**
        * @param ManagerService $managerService
        * @return \Illuminate\View\View
        * @throws 
        * @author Rafael Osuna
        * @description Carga la vista del manager con las estadísticas obtenidas del servicio.
        */
    public function index(ManagerService $managerService)
    {
        $datos = $managerService->obtenerEstadisticas();

        return view('manager.inicio', $datos);
    }
    
}