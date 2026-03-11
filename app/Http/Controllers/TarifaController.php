<?php

namespace App\Http\Controllers;

use App\Models\Tarifa;
use App\Models\Producto;
use App\Models\Contrato;
use App\Http\Requests\DynamicRequestValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\TarifaService;

class TarifaController extends Controller {
    private $tarifaService;

    /**
        * @param TarifaService $tarifaService
        * @return void
        * @author Alonso Coronado Alcalde
        * @description Inyecta el servicio de tarifas.
    */
    public function __construct(TarifaService $tarifaService) {
        $this->tarifaService = $tarifaService;
    }
    /**
        * @param  DynamicRequestValidator $request
        * @return \Illuminate\View\View
        * @throws 
        * @author Rafael Osuna
        * @description  Muestra la vista de tarifas con la lista de tarifas obtenida de la base de datos.
    */
    public function mostrarTarifas(DynamicRequestValidator $request) {
        // Obtenemos todas las tarifas con sus productos asignados (Eager Loading)
        $tarifas = Tarifa::with('productos')->get();
        // Obtenemos todos los productos para el select del formulario
        $productos = Producto::all();

        return view('tarifas.inicio', compact('tarifas', 'productos'));
    }

    /**
        * @param  DynamicRequestValidator $request
        * @return \Illuminate\Http\RedirectResponse
        * @throws  
        * @author Rafael Osuna
        * @description Valida los datos del formulario y guarda una nueva tarifa en la base de datos, luego redirige a la vista de tarifas con un mensaje de éxito.
    */
    public function guardarTarifa(DynamicRequestValidator $request) {
        $tarifaCreada = $this->tarifaService->guardarTarifaBD($request);

        // Si la petición es AJAX, respondemos con JSON
        if ($request->ajax()) {
            if (!$tarifaCreada) {
                return response()->json(['success' => false, 'message' => 'La tarifa ya existe.'], 422);
            }
            return response()->json(['success' => true, 'message' => 'Tarifa creada correctamente.']);
        }

        if (!$tarifaCreada) {
            return redirect()->route('mostrarTarifas')->with('errorTC', 'La tarifa ya existe.');
        }

        return redirect()->route('mostrarTarifas')->with('successTC', 'Tarifa creada correctamente junto a sus productos.');
    }

    /**
        * @param  int $id
        * @return \Illuminate\Http\RedirectResponse
        * @author Alonso Coronado Alcalde
        * @description Elimina una tarifa, sus contratos asociados e informa a los usuarios afectados.
    */
    public function eliminarTarifa(Request $request, $id) {
        $tarifa = Tarifa::findOrFail($id);

        $this->tarifaService->eliminarTarifaBD($tarifa);

        // Si es AJAX, respondemos con éxito
        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Tarifa eliminada con éxito.']);
        }

        return redirect()->route('mostrarTarifas')->with('successTC', 'Tarifa eliminada y contratos cancelados correctamente.');
    }
}