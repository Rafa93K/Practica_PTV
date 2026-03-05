<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClienteController extends Controller {
    public function index() {
        //Obtener el ID del cliente de la sesión
        $clienteId = session('user_id');
        $userType = session('user_type');

        if (!$clienteId || $userType !== 'cliente') {
            return redirect()->route('login', 'cliente')->withErrors(['email' => 'Debes iniciar sesion como cliente']);
        }

        //Buscar al cliente con sus relaciones: contratos -> tarifas, y facturas
        $cliente = Cliente::with(['contratos.tarifas', 'facturas'])->find($clienteId);

        if (!$cliente) {
            return redirect()->route('login', 'cliente')->withErrors(['email' => 'Cliente no encontrado']);
        }

        return view('cliente.panelCliente', compact('cliente'));
    }

    private array $rules=[
        'nombre' => 'required|string|max:255',
        'apellidos' => 'required|string|max:255',
        'dni' => 'required|string|max:9|unique:clientes,dni',
        'email' => 'required|string|email|max:255|unique:clientes,email',
        'telefono' => 'required|string|max:9',
        'password' => 'required|string|min:8',
    ];

    private $errors=[
        'nombre.required' => 'El nombre es obligatorio.',
        'apellidos.required' => 'Los apellidos son obligatorios.',
        'dni.required' => 'El DNI es obligatorio.',
        'dni.unique' => 'El DNI ya está registrado.',
        'email.required' => 'El correo electrónico es obligatorio.',
        'email.email' => 'El correo electrónico no es válido.',
        'email.unique' => 'El correo electrónico ya está registrado.',
        'telefono.required' => 'El teléfono es obligatorio.',
        'password.required' => 'La contraseña es obligatoria.',
        'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
    ];

    public function store(Request $request) {
        //Validar los datos que vienen del formulario registro.blade.php
        $request->validate($this->rules,$this->errors);

        //Crear el cliente en la base de datos
        Cliente::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellidos,
            'dni' => $request->dni,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'contraseña' => $request->password,
        ]);

        //Redirigir con mensaje de exito
        return redirect()->route('login', 'cliente')->with('success', '¡Registro completado! Ya puedes iniciar sesión.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Por ahora vacío para futuras implementaciones
    }

    /**
     * Muestra el formulario para editar el perfil del cliente.
     */
    public function edit()
    {
        $clienteId = session('user_id');
        $userType = session('user_type');

        if (!$clienteId || $userType !== 'cliente') {
            return redirect()->route('login', 'cliente')->withErrors(['email' => 'Debes iniciar sesion como cliente']);
        }

        $cliente = Cliente::find($clienteId);

        if (!$cliente) {
            return redirect()->route('login', 'cliente')->withErrors(['email' => 'Cliente no encontrado']);
        }

        return view('cliente.editarPerfil', compact('cliente'));
    }

    /**
     * Actualiza el correo electrónico y el teléfono del cliente.
     */
    public function update(Request $request)
    {
        $clienteId = session('user_id');
        $userType = session('user_type');

        if (!$clienteId || $userType !== 'cliente') {
            return redirect()->route('login', 'cliente')->withErrors(['email' => 'Debes iniciar sesion como cliente']);
        }

        $cliente = Cliente::find($clienteId);

        if (!$cliente) {
            return redirect()->route('login', 'cliente')->withErrors(['email' => 'Cliente no encontrado']);
        }

        // Validar solo los campos editables
        $request->validate([
            'email' => 'required|string|email|max:255|unique:clientes,email,' . $cliente->id,
            'telefono' => 'required|string|max:9',
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico no es válido.',
            'email.unique' => 'El correo electrónico ya está registrado por otro usuario.',
            'telefono.required' => 'El teléfono es obligatorio.',
        ]);

        // Actualizar solo email y teléfono
        $cliente->email = $request->email;
        $cliente->telefono = $request->telefono;
        $cliente->save();

        return redirect()->route('cliente.editar')->with('success', '¡Perfil actualizado correctamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Por ahora vacío para futuras implementaciones
    }
}
