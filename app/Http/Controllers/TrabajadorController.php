<?php

namespace App\Http\Controllers;

use App\Http\Requests\DynamicRequestValidator;
use App\Models\Trabajadore;
use Illuminate\Support\Facades\Hash;

class TrabajadorController extends Controller
{
    /**
        * @param DynamicRequestValidator $request
        * @return \Illuminate\View\View
        * @throws 
        * @author Rafael Osuna
        * @description  Muestra la vista para crear un nuevo trabajador, solo accesible para el manager.
        */
    public function crearTrabajador(DynamicRequestValidator $request)
    {
        return view('manager.crearTrabajador');
    }

    
    /**
        * @param  DynamicRequestValidator $request
        * @return \Illuminate\Http\RedirectResponse
        * @throws  
        * @author Rafael Osuna
        * @description Valida los datos del formulario y guarda un nuevo trabajador en la base de datos, luego redirige a la vista del manager con un mensaje de éxito.
        */
    public function trabajadorSubmit(DynamicRequestValidator $request)
    {

        // Crear trabajador mediante sql

         

        Trabajadore::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'dni' => strtoupper($request->dni),
            'telefono' => $request->telefono,
            'email' => $request->email,
            'contraseña' => Hash::make($request->password),
            'rol' => $request->rol,
        ]);

        return redirect()->route('manager.inicio')
            ->with('successTC', 'Trabajador creado correctamente');
    }

}
