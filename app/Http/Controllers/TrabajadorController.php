<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trabajadore;
use Illuminate\Support\Facades\Hash;

class TrabajadorController extends Controller
{

    private array $rules=[
        'nombre' => 'required|string|max:255',
        'apellido' => 'required|string|max:255',
        'dni' => 'required|string|max:9|unique:clientes,dni',
        'email' => 'required|string|email|max:255|unique:clientes,email',
        'telefono' => 'required|string|max:9',
        'password' => 'required|string|min:8',
        'rol' => 'required|in:manager,marketing,jefe_tecnico,tecnico',
    ];

    private $errors=[
        'nombre.required' => 'El nombre es obligatorio.',
        'apellido.required' => 'Los apellidos son obligatorios.',
        'dni.required' => 'El DNI es obligatorio.',
        'dni.unique' => 'El DNI ya está registrado.',
        'email.required' => 'El correo electrónico es obligatorio.',
        'email.email' => 'El correo electrónico no es válido.',
        'email.unique' => 'El correo electrónico ya está registrado.',
        'telefono.required' => 'El teléfono es obligatorio.',
        'password.required' => 'La contraseña es obligatoria.',
        'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
        'rol.required' => 'El rol es obligatorio.',
    ];
    public function crearTrabajador()
    {
        return view('manager.crearTrabajador');
    }

     // Procesa el formulario y guarda el trabajador
    public function trabajadorSubmit(Request $request)
    {
        // Validar datos
        $request->validate([$this->rules,$this->errors]);

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
