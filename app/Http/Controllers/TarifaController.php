<?php

namespace App\Http\Controllers;

use App\Models\Tarifa;
use App\Models\Producto;
use App\Models\Contrato;
use App\Http\Requests\DynamicRequestValidator;
use Illuminate\Support\Facades\DB;

class TarifaController extends Controller {
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
        // Iniciamos transacción para asegurar consistencia
        DB::transaction(function() use ($request) {
            // Creamos la tarifa con los datos básicos
            $tarifa = Tarifa::create([
                'nombre' => $request->nombre,
                'tipo' => $request->tipo,
                'precio' => $request->precio,
                'descripcion' => $request->descripcion,
            ]);

            // Si se han seleccionado productos, los asociamos en la tabla pivote
            if ($request->has('productos')) {
                // Filtramos nulos o vacíos por seguridad
                $productosValidos = array_filter($request->productos);
                if (!empty($productosValidos)) {
                    $tarifa->productos()->attach($productosValidos);
                }
            }
        });

        return redirect()->route('mostrarTarifas')->with('successTC', 'Tarifa creada correctamente junto a sus productos.');
    }

    /**
        * @param  int $id
        * @return \Illuminate\Http\RedirectResponse
        * @author Alonso Coronado Alcalde
        * @description Elimina una tarifa, sus contratos asociados e informa a los usuarios afectados.
    */
    public function eliminarTarifa($id) {
        //Buscamos la tarifa por su ID
        $tarifa = Tarifa::findOrFail($id);

        //Hacemos una transaction ya que en caso de error, se revertiran todos los cambios
        DB::transaction(function() use ($tarifa) {
            //Buscamos los IDs de los contratos que tienen esta tarifa asignada
            $contratosIds = $tarifa->contratos()->pluck('contratos.id');
            
            //Eliminamos la tarifa
            $tarifa->delete();

            //Eliminamos los contratos asociados, para los clientes que la tengan contratada
            if ($contratosIds->isNotEmpty()) {
                Contrato::whereIn('id', $contratosIds)->delete();
            }
        });

        //Retornamos con el mensaje de exito
        return redirect()->route('mostrarTarifas')->with('successTC', 'Tarifa eliminada y contratos cancelados correctamente.');
    }
}