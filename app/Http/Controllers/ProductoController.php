<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Http\Requests\DynamicRequestValidator;

class ProductoController extends Controller
{
    /**
        * @param  DynamicRequestValidator $request
        * @return \Illuminate\View\View
        * @throws  
        * @author Rafael Osuna
        * @description  Muestra la vista de productos con la lista de productos obtenida de la base de datos.
        */
    public function mostrarProducto(DynamicRequestValidator $request)
    {
        $productos=Producto::all();

        return view('producto.inicio',compact('productos'));
    }

    /**
        * @param  DynamicRequestValidator $request
        * @return \Illuminate\Http\RedirectResponse
        * @throws  
        * @author Rafael Osuna
        * @description Valida los datos del formulario y guarda un nuevo producto en la base de datos, luego redirige a la vista de productos con un mensaje de éxito.
        */
    public function guardarProducto(DynamicRequestValidator $request) 
    {
        
        Producto::create([
            'nombre'=>$request->nombre,
            'cantidad'=>$request->cantidad,
            'precio'=>$request->precio,
        ]);

         return redirect()->route('mostrarProducto')
            ->with('successPC', 'Trabajador creado correctamente');



    }
}
