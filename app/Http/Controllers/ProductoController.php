<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{

    private array $rules = [
        'nombre' => 'required|string|max:255',
        'cantidad' => 'required|integer|min:0',
        'precio' => 'required|numeric|min:0',
    ];

    private array $errors = [
        'nombre.required' => 'El nombre del producto es obligatorio.',
        'cantidad.required' => 'La cantidad es obligatoria.',
        'cantidad.integer' => 'La cantidad debe ser un número entero.',
        'precio.required' => 'El precio es obligatorio.',
        'precio.numeric' => 'El precio debe ser numérico.',
    ];
    //me muestra la vista con los productos
    public function mostrarProducto()
    {
        $productos=Producto::all();

        return view('producto.inicio',compact('productos'));
    }

    public function guardarProducto(Request $request) 
    {
        //valida datos
        $request->validate($this->rules, $this->errors);
        
        Producto::create([
            'nombre'=>$request->nombre,
            'cantidad'=>$request->cantidad,
            'precio'=>$request->precio,
        ]);

         return redirect()->route('mostrarProducto')
            ->with('successPC', 'Trabajador creado correctamente');



    }
}
