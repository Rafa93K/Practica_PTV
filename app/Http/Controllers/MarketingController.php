<?php

namespace App\Http\Controllers;

use App\Services\MarketingService;
use Illuminate\Http\Request;

class MarketingController extends Controller {
    /**
     * @param MarketingService $marketingService
     * @return \Illuminate\View\View
     * @throws 
     * @author Rafael Osuna
     * @description Carga la vista del marketing con las estadísticas obtenidas del servicio.
    */
    public function index(MarketingService $marketingService) {
        $datos = $marketingService->obtenerDatos();
        $datos['meses'] = $marketingService->obtenerMeses();
        $datos['años'] = $marketingService->obtenerAños();
        $datos['mesSeleccionado'] = null;
        $datos['añoSeleccionado'] = null;

        return view('marketing.inicio', $datos);
    }

    public function filtrar(Request $request, MarketingService $marketingService) {
        $periodo = $request->input('periodo'); // Recibimos "YYYY-MM"
        $mes = null;
        $año = null;

        if ($periodo) {
            $partes = explode('-', $periodo);
            $año = $partes[0];
            $mes = $partes[1];
        }

        $datos = $marketingService->obtenerDatos($mes, $año);
        $datos['meses'] = $marketingService->obtenerMeses();
        $datos['años'] = $marketingService->obtenerAños();
        $datos['mesSeleccionado'] = (int)$mes;
        $datos['añoSeleccionado'] = (int)$año;

        return view('marketing.inicio', $datos);
    }
}