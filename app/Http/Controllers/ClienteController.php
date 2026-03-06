<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Factura;
use App\Models\Incidencia;
use App\Models\Tarifa;
use App\Models\Contrato;
use App\Services\ClienteService;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Requests\DynamicRequestValidator;

class ClienteController extends Controller {
    private ClienteService $clienteService;

    /**
     * @param ClienteService $clienteService
     * @author Alonso Coronado Alcalde
     * @description Inyecta el servicio de cliente.
     */
    public function __construct(ClienteService $clienteService) {
        $this->clienteService = $clienteService;
    }

    /**
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Validation\ValidationException
     * @author Alonso Coronado Alcalde
     * @description Carga el panel del cliente con sus contratos y facturas.
     */
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

    /**
     * @param DynamicRequestValidator $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     * @author Alonso Coronado Alcalde
     * @description Guarda el cliente en la base de datos.
     */
    public function guardarClienteBD(DynamicRequestValidator $request) {
        $cliente = $this->clienteService->crearCliente($request);

        //En caso de que no se cree el cliente, devolvemos error
        if (!$cliente) {
            return redirect()->route('login', 'cliente')->withErrors(['email' => 'Error al crear el cliente']);
        }

        //Redirigir con mensaje de exito
        return redirect()->route('login', 'cliente')->with('success', '¡Registro completado! Ya puedes iniciar sesión.');
    }

    /**
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Validation\ValidationException
     * @author Alonso Coronado Alcalde
     * @description Muestra el formulario para editar el perfil del cliente.
     */
    public function mostrarFormularioEditar() {
        $clienteId = $this->clienteService->comprobarUsuario();
        $cliente = Cliente::find($clienteId);

        if (!$cliente) {
            return redirect()->route('login', 'cliente')->withErrors(['email' => 'Cliente no encontrado']);
        }

        return view('cliente.editarPerfil', compact('cliente'));
    }

    /**
     * @param DynamicRequestValidator $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     * @author Alonso Coronado Alcalde
     * @description Actualiza el correo electrónico y el teléfono del cliente.
     */
    public function actualizarClienteBD(DynamicRequestValidator $request) {
        $clienteId = $this->clienteService->comprobarUsuario();
        $cliente = Cliente::find($clienteId);

        //En caso de que no se encuentre el cliente, devolvemos error
        if (!$cliente) {
            return redirect()->route('login', 'cliente')->withErrors(['email' => 'Cliente no encontrado']);
        }

        $cliente = $this->clienteService->actualizarCliente($request);

        //En caso de que no se actualice el cliente, devolvemos error
        if (!$cliente) {
            return redirect()->route('cliente.editar')->withErrors(['email' => 'Error al actualizar el perfil']);
        }

        //Redirigir con mensaje de exito
        return redirect()->route('cliente.editar')->with('success', '¡Perfil actualizado correctamente!');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     * @author Alonso Coronado Alcalde
     * @description Genera la factura en formato PDF.
     */
    public function generarFactura($id) {
        $clienteId = $this->clienteService->comprobarUsuario();
        $factura = Factura::find($id); //Busca la factura por ID
        $cliente = Cliente::find($clienteId); //Busca el cliente por ID

        if (!$cliente) {
            return redirect()->route('login', 'cliente')->withErrors(['email' => 'Cliente no encontrado']);
        }

        //Cargar la vista de la factura con los datos del cliente y la factura
        $pdf = PDF::loadView('pdf.factura', compact('cliente', 'factura'));
        return $pdf->stream('factura.pdf'); //Muestra la factura en el navegador
    }

    /**
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Validation\ValidationException
     * @author Alonso Coronado Alcalde
     * @description Muestra el formulario para realizar una nueva incidencia.
     */
    public function mostrarFormularioIncidencia() {
        $clienteId = $this->clienteService->comprobarUsuario();
        $cliente = Cliente::find($clienteId);

        if (!$cliente) {
            return redirect()->route('login', 'cliente')->withErrors(['email' => 'Cliente no encontrado']);
        }

        return view('cliente.crearIncidencia', compact('cliente'));
    }

    /**
     * @param DynamicRequestValidator $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     * @author Alonso Coronado Alcalde
     * @description Guarda una nueva incidencia en la base de datos.
     */
    public function guardarIncidenciaBD(DynamicRequestValidator $request) {
        $clienteId = $this->clienteService->comprobarUsuario();
        $cliente = Cliente::find($clienteId);

        if (!$cliente) {
            return redirect()->route('login', 'cliente')->withErrors(['email' => 'Cliente no encontrado']);
        }

        $incidencia = new Incidencia();
        $incidencia->cliente_id = $cliente->id;
        $incidencia->descripcion = $request->descripcion;
        $incidencia->estado = 'abierto';
        $incidencia->fecha = now();
        $incidencia->save();


        return redirect()->route('cliente.incidencia.create')->with('success', '¡Incidencia enviada correctamente! Un técnico revisará su caso.');
    }

    /**
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Validation\ValidationException
     * @author Alonso Coronado Alcalde
     * @description Muestra todas las tarifas disponibles para contratar.
     */
    public function verTarifas() {
        $clienteId = $this->clienteService->comprobarUsuario();
        $cliente = Cliente::find($clienteId);

        if (!$cliente) {
            return redirect()->route('login', 'cliente')->withErrors(['email' => 'Cliente no encontrado']);
        }

        $tarifas = Tarifa::all();

        return view('cliente.verTarifas', compact('cliente', 'tarifas'));
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Validation\ValidationException
     * @author Alonso Coronado Alcalde
     * @description Muestra el formulario para contratar una tarifa.
     */
    public function contratarTarifa($id) {
        $clienteId = $this->clienteService->comprobarUsuario();
        $cliente = Cliente::find($clienteId);

        if (!$cliente) {
            return redirect()->route('login', 'cliente')->withErrors(['email' => 'Cliente no encontrado']);
        }

        $tarifa = Tarifa::find($id);

        if (!$tarifa) {
            return redirect()->route('cliente.tarifas')->withErrors(['email' => 'Tarifa no encontrada']);
        }

        return view('cliente.contratarTarifa', compact('cliente', 'tarifa'));
    }

    /**
     * @param DynamicRequestValidator $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     * @author Alonso Coronado Alcalde
     * @description Guarda un nuevo contrato en la base de datos.
     */
    public function guardarContratoBD(DynamicRequestValidator $request) {
        $clienteId = $this->clienteService->comprobarUsuario();
        
        $contrato = new Contrato();
        $contrato->cliente_id = $clienteId;
        $contrato->provincia = $request->provincia;
        $contrato->ciudad = $request->ciudad;
        $contrato->calle = $request->calle;
        $contrato->numero = $request->numero;
        $contrato->puerta = $request->puerta;
        $contrato->codigo_postal = $request->codigo_postal;
        $contrato->aprobado = false; // El contrato se crea como pendiente de aprobación
        $contrato->save();

        // Vincular la tarifa al contrato (relación muchos a muchos) con la fecha de hoy
        $contrato->tarifas()->attach($request->tarifa_id, [
            'fecha_inicio' => now()
        ]);

        return redirect()->route('cliente.inicio')->with('success', '¡Solicitud de contratación enviada correctamente! Un agente revisará los datos.');
    }
}