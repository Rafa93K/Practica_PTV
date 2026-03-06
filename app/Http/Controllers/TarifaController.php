<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarifa;

class TarifaController extends Controller
{

    private array $rules = [
        'nombre' => 'required|string|max:255',
        'tipo' => 'required|string|max:255',
        'precio' => 'required|numeric|min:0',
        'descripcion' => 'nullable|string',
    ];
    private array $errors = [
        'nombre.required' => 'El nombre del producto es obligatorio.',
        'tipo.required' => 'El tipo es obligatorio.',
        'precio.required' => 'El precio es obligatorio.',
        'precio.numeric' => 'El precio debe ser numérico.',
        'descripcion.string' => 'La descripción debe ser un texto.',

    ];




    /**
        * @param  Request $request
        * @return \Illuminate\View\View
        * @throws 
        * @author Rafael Osuna
        * @description  Muestra la vista de tarifas con la lista de tarifas obtenida de la base de datos.
        */
    public function mostrarTarifas()
    {
        $tarifas=Tarifa::all();
        return view('tarifas.inicio',compact('tarifas'));
    }


    /**
        * @param  Request $request
        * @return \Illuminate\Http\RedirectResponse
        * @throws  
        * @author Rafael Osuna
        * @description Valida los datos del formulario y guarda una nueva tarifa en la base de datos, luego redirige a la vista de tarifas con un mensaje de éxito.
        */
    public function guardarTarifa(Request $request) 
    {
        //valida datos
        $request->validate($this->rules, $this->errors);
        
        Tarifa::create([
            'nombre'=>$request->nombre,
            'tipo'=>$request->tipo,
            'precio'=>$request->precio,
            'descripcion'=>$request->descripcion,
        ]);

         return redirect()->route('mostrarTarifas')
            ->with('successTC', 'Tarifa creada correctamente');



    }

    
    
    
}
