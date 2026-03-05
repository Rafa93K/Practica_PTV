<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Services\ClienteService;
use Illuminate\Http\Request;

class ClienteController extends Controller {
    private ClienteService $clienteService;

    public function __construct(ClienteService $clienteService) {
        $this->clienteService = $clienteService;
    }

    public function cargarPanelCliente() {
        $clienteId = $this->clienteService->comprobarUsuario();

        //Buscar al cliente con sus relaciones: contratos -> tarifas, y facturas
        $cliente = Cliente::with(['contratos.tarifas', 'facturas'])->find($clienteId);

        //Si no existe el cliente lo devolvemos
        if (!$cliente) {
            return redirect()->route('login', 'cliente')->withErrors(['email' => 'Cliente no encontrado']);
        }

        return view('cliente.panelCliente', compact('cliente'));
    }

    //Reglas para validar el formulario de registro
    private array $rules=[
        'nombre' => 'required|string|max:255',
        'apellidos' => 'required|string|max:255',
        'dni' => 'required|string|max:9|unique:clientes,dni',
        'email' => 'required|string|email|max:255|unique:clientes,email',
        'telefono' => 'required|string|max:9',
        'password' => 'required|string|min:8',
    ];

    //Mensajes de error para el formulario de registro
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

    public function guardarClienteBD(Request $request) {
        //Validar los datos que vienen del formulario registro.blade.php
        $request->validate($this->rules,$this->errors);

        $cliente = $this->clienteService->crearCliente($request);

        //En caso de que no se cree el cliente, devolvemos error
        if (!$cliente) {
            return redirect()->route('login', 'cliente')->withErrors(['email' => 'Error al crear el cliente']);
        }

        //Redirigir con mensaje de exito
        return redirect()->route('login', 'cliente')->with('success', '¡Registro completado! Ya puedes iniciar sesión.');
    }

    /**
     * Muestra el formulario para editar el perfil del cliente.
     */
    public function mostrarFormularioEditar()
    {
        $clienteId = $this->clienteService->comprobarUsuario();

        $cliente = Cliente::find($clienteId);

        if (!$cliente) {
            return redirect()->route('login', 'cliente')->withErrors(['email' => 'Cliente no encontrado']);
        }

        return view('cliente.editarPerfil', compact('cliente'));
    }

    /**
     * Actualiza el correo electrónico y el teléfono del cliente.
     */
    public function actualizarClienteBD(Request $request)
    {
        $clienteId = $this->clienteService->comprobarUsuario();

        $cliente = Cliente::find($clienteId);

        //En caso de que no se encuentre el cliente, devolvemos error
        if (!$cliente) {
            return redirect()->route('login', 'cliente')->withErrors(['email' => 'Cliente no encontrado']);
        }

        //Validar solo los campos editables
        $request->validate([
            'email' => 'required|string|email|max:255|unique:clientes,email,' . $cliente->id,
            'telefono' => 'required|string|max:9',
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico no es válido.',
            'email.unique' => 'El correo electrónico ya está registrado por otro usuario.',
            'telefono.required' => 'El teléfono es obligatorio.',
        ]);

        $cliente = $this->clienteService->actualizarCliente($request);

        //En caso de que no se actualice el cliente, devolvemos error
        if (!$cliente) {
            return redirect()->route('cliente.editar')->withErrors(['email' => 'Error al actualizar el perfil']);
        }

        //Redirigir con mensaje de exito
        return redirect()->route('cliente.editar')->with('success', '¡Perfil actualizado correctamente!');
    }
}