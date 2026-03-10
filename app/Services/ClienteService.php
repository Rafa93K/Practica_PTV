<?php

namespace App\Services;
use App\Http\Requests\DynamicRequestValidator;
use App\Models\Cliente;
use App\Models\Contrato;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ClienteService {
    /**
     * @return int
     * @throws \Illuminate\Validation\ValidationException
     * @author Alonso Coronado Alcalde
     * @description Comprueba que el usuario que intenta acceder es un cliente.
     */
    public function comprobarUsuario() {
        //Comprueba que el usuario que intenta acceder es un cliente
        $clienteId = session('user_id');
        $userType = session('user_type');

        //Si no es un cliente o no existe, lo devolvemos a la pagina de login
        if (!$clienteId || $userType !== 'cliente') {
            return redirect()->route('login', 'cliente')->withErrors(['email' => 'Debes iniciar sesion como cliente']);
        }

        return $clienteId; //Devolvemos el ID del cliente
    }

    /**
     * @param Request $request
     * @return \App\Models\Cliente
     * @throws \Illuminate\Validation\ValidationException
     * @autho0r Alonso Coronado Alcalde
     * @description Crea un nuevo cliente.
     */
    public function crearCliente(DynamicRequestValidator $request) {
        //Crear el cliente
        $cliente = Cliente::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'dni' => $request->dni,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'contraseña' => Hash::make($request->password),
        ]);

        return $cliente; //Devolvemos el cliente creado
    }

    /**
     * @param Request $request
     * @return \App\Models\Cliente
     * @throws \Illuminate\Validation\ValidationException
     * @author Alonso Coronado Alcalde
     * @description Actualiza el correo electrónico y el teléfono del cliente.
     */
    public function actualizarCliente(DynamicRequestValidator $request) {
        $clienteId = $this->comprobarUsuario();
        $cliente = Cliente::find($clienteId);
        
        //Actualizar solo email y teléfono
        $cliente->email = $request->email;
        $cliente->telefono = $request->telefono;
        $cliente->save();

        return $cliente; //Devolvemos el cliente actualizado
    }

    /**
     * @param DynamicRequestValidator $request
     * @return \App\Models\Cliente
     * @throws \Illuminate\Validation\ValidationException
     * @author Alonso Coronado Alcalde
     * @description Contrata una nueva tarifa para el cliente.
     */
    public function contratarTarifa(DynamicRequestValidator $request) {
        $clienteId = $this->comprobarUsuario();
        $cliente = Cliente::find($clienteId);

        $contrato = Contrato::create([
            'cliente_id' => $clienteId,
            'provincia' => $request->provincia,
            'ciudad' => $request->ciudad,
            'calle' => $request->calle,
            'numero' => $request->numero,
            'puerta' => $request->puerta,
            'codigo_postal' => $request->codigo_postal,
            'aprobado' => false,
        ]);
        
        //Contratar la tarifa
        $contrato->tarifas()->attach($request->tarifa_id, [
            'fecha_inicio' => now()
        ]);

        return $cliente; //Devolvemos el cliente actualizado
    }

    /**
     * @param int $contratoId
     * @param int $tarifaId
     * @return bool
     * @description Cancela un servicio eliminando la relación entre el contrato y la tarifa.
     */
    public function cancelarServicio($contratoId, $tarifaId) {
        $contrato = Contrato::find($contratoId);
        if (!$contrato) return false;

        // Desvincular la tarifa del contrato
        $contrato->tarifas()->detach($tarifaId);

        // Si el contrato se queda sin tarifas, se podría eliminar el contrato, 
        // pero por ahora solo borramos la relación como se pidió.
        return true;
    }

    /**
     * @param int $contratoId
     * @param int $tarifaActualId
     * @param int $nuevaTarifaId
     * @return bool
     * @description Cambia una tarifa por otra en un contrato existente.
     */
    public function cambiarServicio($contratoId, $tarifaActualId, $nuevaTarifaId) {
        $contrato = Contrato::find($contratoId);
        if (!$contrato) return false;

        // Desvincular la antigua y vincular la nueva
        $contrato->tarifas()->detach($tarifaActualId);
        $contrato->tarifas()->attach($nuevaTarifaId, [
            'fecha_inicio' => now()
        ]);

        return true;
    }
}