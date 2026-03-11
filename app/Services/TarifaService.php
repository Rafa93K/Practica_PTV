<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Tarifa;
use App\Models\Contrato;

class TarifaService {
    public function comprobarDuplicado($request) {
        //Convertimos el valor del checkbox a booleano para que coincida con la BD
        $permanencia = $request->has('permanencia') ? true : false;

        //Comprobamos si la tarifa ya existe buscando todos los campos
        $tarifaExistente = Tarifa::where('nombre', $request->nombre)
            ->where('tipo', $request->tipo)
            ->where('precio', $request->precio)
            ->where('descripcion', $request->descripcion)
            ->where('permanencia', $permanencia)
            ->first();

        return $tarifaExistente;
    }

    public function guardarTarifaBD($request) {
        DB::beginTransaction();
        try {
            //Comprobamos si la tarifa ya existe
            $tarifaExistente = $this->comprobarDuplicado($request);
            if ($tarifaExistente) {
                DB::rollBack(); //Cerramos la transacción si ya existe
                return false;
            }

            //Creamos la nueva tarifa con los datos básicos del REQUEST
            $nuevaTarifa = Tarifa::create([
                'nombre'      => $request->nombre,
                'tipo'        => $request->tipo,
                'precio'      => $request->precio,
                'descripcion' => $request->descripcion,
                'permanencia' => $request->has('permanencia') ? 1 : 0,
            ]);

            //Si se han seleccionado productos en el formulario (REQUEST), los asociamos
            if ($request->has('productos')) {
                $productosValidos = array_filter($request->productos);
                if (!empty($productosValidos)) {
                    $nuevaTarifa->productos()->attach($productosValidos);
                }
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
        DB::commit();
        return true; //Devolvemos true para indicar que se creó correctamente
    }

    public function eliminarTarifaBD($tarifa) {
        DB::beginTransaction();
        try {
            //Buscamos los IDs de los contratos que tienen esta tarifa asignada
            $contratosIds = $tarifa->contratos()->pluck('contratos.id');
            
            //Eliminamos la tarifa
            $tarifa->delete();

            //Eliminamos los contratos asociados, para los clientes que la tengan contratada
            if ($contratosIds->isNotEmpty()) {
                Contrato::whereIn('id', $contratosIds)->delete();
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
        DB::commit();
    }
}