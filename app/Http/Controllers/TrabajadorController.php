<?php

namespace App\Http\Controllers;

use App\Http\Requests\DynamicRequestValidator;
use App\Models\Trabajadore;
use Illuminate\Support\Facades\Hash;

class TrabajadorController extends Controller
{

    private array $rules = [
        'nombre' => 'required|string|max:255',
        'apellido' => 'required|string|max:255',
        'dni' => 'required|string|max:9|unique:trabajadores,dni',
        'email' => 'required|string|email|max:255|unique:trabajadores,email',
        'telefono' => 'required|string|max:9',
        'contraseña' => 'required|string|min:8',
        'rol' => 'required|in:manager,marketing,jefe_tecnico,tecnico',
    ];

    private $errors = [
        'nombre.required' => 'El nombre es obligatorio.',
        'apellido.required' => 'Los apellidos son obligatorios.',
        'dni.required' => 'El DNI es obligatorio.',
        'dni.unique' => 'El DNI ya está registrado.',
        'email.required' => 'El correo electrónico es obligatorio.',
        'email.email' => 'El correo electrónico no es válido.',
        'email.unique' => 'El correo electrónico ya está registrado.',
        'telefono.required' => 'El teléfono es obligatorio.',
        'contraseña.required' => 'La contraseña es obligatoria.',
        'contraseña.min' => 'La contraseña debe tener al menos 8 caracteres.',
        'rol.required' => 'El rol es obligatorio.',
    ];

    /**
        * @return \Illuminate\View\View
        * @throws 
        * @author Rafael Osuna
        * @description  Muestra la vista para crear un nuevo trabajador, solo accesible para el manager.
    */
    public function crearTrabajador() {
        return view('manager.crearTrabajador');
    }

    /**
        * @param  DynamicRequestValidator $request
        * @return \Illuminate\Http\RedirectResponse
        * @throws  
        * @author Rafael Osuna
        * @description Valida los datos del formulario y guarda un nuevo trabajador en la base de datos, luego redirige a la vista del manager con un mensaje de éxito.
        */
    public function trabajadorSubmit(Request $request)
    {
        // Validar datos
        $request->validate($this->rules, $this->errors);

        Trabajadore::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'dni' => strtoupper($request->dni),
            'telefono' => $request->telefono,
            'email' => $request->email,
            'contraseña' => Hash::make($request->contraseña),
            'rol' => $request->rol,
        ]);

        return redirect()->route(session('user_role') . '.inicio')
            ->with('successTC', 'Trabajador creado correctamente');
    }
}