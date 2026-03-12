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
        $mes = $request->input('mes'); //Obtengo el mes seleccionado
        $año = $request->input('año'); //Obtengo el año seleccionado

        $datos = $marketingService->obtenerDatos($mes, $año); //Obtengo los datos filtrados
        $datos['meses'] = $marketingService->obtenerMeses(); //Obtengo los meses
        $datos['años'] = $marketingService->obtenerAños(); //Obtengo los años
        $datos['mesSeleccionado'] = $mes; //Selecciono el mes
        $datos['añoSeleccionado'] = $año; //Selecciono el año

        return view('marketing.inicio', $datos); //Devuelvo la vista con los datos filtrados
    }
}