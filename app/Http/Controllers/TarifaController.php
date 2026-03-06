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




    public function mostrarTarifas()
    {
        $tarifas=Tarifa::all();
        return view('tarifas.inicio',compact('tarifas'));
    }


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
