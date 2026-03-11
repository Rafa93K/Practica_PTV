<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Factura;
use App\Models\Tarifa;
use App\Services\ClienteService;
use Illuminate\Support\Facades\DB;

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

        $sql = "
            INSERT INTO incidencias (cliente_id, descripcion, estado, fecha)
            VALUES ('$cliente->id', '$request->descripcion', 'pendiente', NOW())
        ";
        DB::statement($sql);

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
     * @param int $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     * @author Rafael Osuna
     * @description Muestra el formulario de contratación para un nuevo cliente (registro + contrato).
     */
    public function mostrarFormularioContratacionDirecta($id) {
        $tarifa = Tarifa::find($id);
        if (!$tarifa) {
            return redirect()->route('inicio')->withErrors(['error' => 'Tarifa no encontrada']);
        }
        return view('cliente.contratacionDirecta', compact('tarifa'));
    }

    /**
     * @param \App\Http\Requests\DynamicRequestValidator $request
     * @return \Illuminate\Http\RedirectResponse
     * @author Rafael Osuna
     * @description Procesa el registro de un nuevo cliente y la creación de su primer contrato.
     */
    public function procesarContratacionDirecta(DynamicRequestValidator $request) {
        $cliente = $this->clienteService->crearCliente($request);
        
        if (!$cliente) {
            return redirect()->back()->withInput()->withErrors(['email' => 'Error al crear la cuenta de cliente']);
        }

        // Simular inicio de sesión para el nuevo cliente
        session(['user_id' => $cliente->id, 'user_type' => 'cliente']);

        // Crear el contrato usando el servicio existente
        $resultado = $this->clienteService->contratarTarifa($request);

        if (!$resultado) {
            return redirect()->route('cliente.inicio')->with('warning', '¡Cuenta creada! Pero hubo un problema al procesar el contrato. Por favor, inténtalo desde tu panel.');
        }

        return redirect()->route('cliente.inicio')->with('success', '¡Bienvenido! Tu cuenta ha sido creada y tu servicio contratado correctamente.');
    }

    

    /**
     * @param DynamicRequestValidator $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     * @author Alonso Coronado Alcalde
     * @description Guarda un nuevo contrato en la base de datos.
     */
    public function guardarContratoBD(DynamicRequestValidator $request) {
        $cliente = $this->clienteService->contratarTarifa($request);

        //En caso de que no se actualice el cliente, devolvemos error
        if (!$cliente) {
            return redirect()->route('cliente.contratarTarifa', $request->tarifa_id)->withErrors(['email' => 'Error al contratar la tarifa']);
        }

        return redirect()->route('cliente.inicio')->with('success', '¡Tarifa contratada correctamente!');
    }

    /**
     * @param int $tarifa_id
     * @param int $contrato_id
     * @return \Illuminate\Contracts\View\View
     * @author Alonso Coronado Alcalde
     * @description Muestra las tarifas del mismo tipo para realizar un cambio.
     */
    public function mostrarCambioServicio($tarifa_id, $contrato_id) {
        $clienteId = $this->clienteService->comprobarUsuario();
        $cliente = Cliente::find($clienteId);

        $tarifaActual = Tarifa::find($tarifa_id);
        if (!$tarifaActual) {
            return redirect()->route('cliente.inicio')->withErrors(['error' => 'Tarifa no encontrada']);
        }

        //Obtener tarifas del mismo tipo excepto la actual
        $sql = "
            SELECT * 
            FROM tarifas 
            WHERE tipo = '$tarifaActual->tipo' 
            AND id != '$tarifa_id'
        ";
        $tarifas = DB::select($sql);

        return view('cliente.cambiarTarifa', compact('cliente', 'tarifas', 'tarifaActual', 'contrato_id'));
    }

    /**
     * @param DynamicRequestValidator $request
     * @return \Illuminate\Http\RedirectResponse
     * @author Alonso Coronado Alcalde
     * @description Procesa el cambio de una tarifa por otra.
     */
    public function procesarCambioServicio(DynamicRequestValidator $request) {
        //Llama al servicio para cambiar el servicio
        $resultado = $this->clienteService->cambiarServicio($request->contrato_id, $request->tarifa_actual_id, $request->nueva_tarifa_id);

        if (!$resultado) {
            return redirect()->route('cliente.inicio')->withErrors(['error' => 'Error al cambiar el servicio']);
        }

        return redirect()->route('cliente.inicio')->with('success', '¡Servicio cambiado correctamente!');
    }

    /**
     * @param int $contrato_id
     * @param int $tarifa_id
     * @return \Illuminate\Http\RedirectResponse
     * @author Alonso Coronado Alcalde
     * @description Cancela un servicio específico.
     */
    public function cancelarServicio($contrato_id, $tarifa_id) {
        //Llama al servicio para cancelar el servicio
        $resultado = $this->clienteService->cancelarServicio($contrato_id, $tarifa_id);

        if (!$resultado) {
            return redirect()->route('cliente.inicio')->withErrors(['error' => 'Error al cancelar el servicio']);
        }

        return redirect()->route('cliente.inicio')->with('success', '¡Servicio cancelado correctamente!');
    }
}