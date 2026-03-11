<?php

namespace App\Http\Controllers;

use App\Models\Tarifa;
use App\Http\Requests\DynamicRequestValidator;

class TarifaController extends Controller {
    /**
        * @param  DynamicRequestValidator $request
        * @return \Illuminate\View\View
        * @throws 
        * @author Rafael Osuna
        * @description  Muestra la vista de tarifas con la lista de tarifas obtenida de la base de datos.
    */
    public function mostrarTarifas(DynamicRequestValidator $request) {
        $tarifas=Tarifa::all();
        return view('tarifas.inicio',compact('tarifas'));
    }

    /**
        * @param  DynamicRequestValidator $request
        * @return \Illuminate\Http\RedirectResponse
        * @throws  
        * @author Rafael Osuna
        * @description Valida los datos del formulario y guarda una nueva tarifa en la base de datos, luego redirige a la vista de tarifas con un mensaje de éxito.
    */
    public function guardarTarifa(DynamicRequestValidator $request) {
        Tarifa::create([
            'nombre'=>$request->nombre,
            'tipo'=>$request->tipo,
            'precio'=>$request->precio,
            'descripcion'=>$request->descripcion,
        ]);

        return redirect()->route('mostrarTarifas')->with('successTC', 'Tarifa creada correctamente');
    }
}