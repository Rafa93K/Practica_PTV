<?php

namespace App\Http\Controllers;

use App\Services\MarketingService;

class MarketingController extends Controller
{
    /**
     * @param MarketingService $marketingService
     * @return \Illuminate\View\View
     * @throws 
     * @author Rafael Osuna
     * @description Carga la vista del marketing con las estadísticas obtenidas del servicio.
     */
    public function index(MarketingService $marketingService)
    {
        $datos = $marketingService->obtenerDatos();

        return view('marketing.inicio', $datos);
    }
}