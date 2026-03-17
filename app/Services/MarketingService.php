<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class MarketingService {
    /**
     * @return array
     * @throws 
     * @author Rafael Osuna
     * @description Obtenemos los datos de las tablas para devolver la informacion al marketing.
     */
    public function obtenerDatos($mes = null, $año = null) {
        $queryContratos = DB::table('contratos'); //Obtengo los contratos de la tabla contratos
        $queryFacturas = DB::table('facturas'); //Obtengo las facturas de la tabla facturas
        $queryContratoTarifa = DB::table('contrato_tarifa'); //Obtengo los contratos de la tabla contrato_tarifa

        if ($mes) { //Si selecciono un mes
            $queryFacturas->whereMonth('fecha_inicio', $mes); //Busco las facturas donde el mes de fecha_inicio sea el mes seleccionado
            $queryContratoTarifa->whereMonth('contrato_tarifa.created_at', $mes); //Busco los contratos donde el mes de created_at sea el mes seleccionado
        }

        if ($año) { //Si selecciono un año
            $queryFacturas->whereYear('fecha_inicio', $año); //Busco las facturas donde el año de fecha_inicio sea el año seleccionado
            $queryContratoTarifa->whereYear('contrato_tarifa.created_at', $año); //Busco los contratos donde el año de created_at sea el año seleccionado
        }

        $totalContratos = $queryContratos->count(); //Obtengo el total de contratos
        
        $producido = $queryFacturas->sum('precio'); //Obtengo el total de facturas
        $invertido = DB::table('productos')->selectRaw('SUM(cantidad * precio) as total')->value('total'); //Obtengo el total de productos
        $beneficio = $producido - $invertido; //Obtengo el beneficio

        // TARIFAS MÁS CONTRATADAS
        $tarifasMasContratadas = $queryContratoTarifa
            ->join('tarifas', 'contrato_tarifa.tarifa_id', '=', 'tarifas.id')
            ->select(
                'tarifas.nombre',
                DB::raw('COUNT(contrato_tarifa.tarifa_id) as total')
            )
            ->groupBy('tarifas.id', 'tarifas.nombre')
            ->orderByDesc('total')
            ->get();

        // Preparar datos para gráficos
        $tarifasLabels = $tarifasMasContratadas->pluck('nombre');
        $tarifasData = $tarifasMasContratadas->pluck('total');

        // Obtener la tarifa más contratada
        $topTarifa = $tarifasMasContratadas->first();

        return [
            'totalContratos' => $totalContratos,
            'producido' => $producido,
            'invertido' => $invertido,
            'beneficio' => $beneficio,

            // datos del gráfico
            'tarifasLabels' => $tarifasLabels,
            'tarifasData' => $tarifasData,
            'topTarifa' => $topTarifa
        ];
    }


    public function obtenerMeses() {
        //Se devuelven los meses a traves de objetos, pasando id y nombre
        return [
            (object)['id' => 1, 'nombre' => 'Enero'],
            (object)['id' => 2, 'nombre' => 'Febrero'],
            (object)['id' => 3, 'nombre' => 'Marzo'],
            (object)['id' => 4, 'nombre' => 'Abril'],
            (object)['id' => 5, 'nombre' => 'Mayo'],
            (object)['id' => 6, 'nombre' => 'Junio'],
            (object)['id' => 7, 'nombre' => 'Julio'],
            (object)['id' => 8, 'nombre' => 'Agosto'],
            (object)['id' => 9, 'nombre' => 'Septiembre'],
            (object)['id' => 10, 'nombre' => 'Octubre'],
            (object)['id' => 11, 'nombre' => 'Noviembre'],
            (object)['id' => 12, 'nombre' => 'Diciembre'],
        ];
    }

    public function obtenerAños() {
        $años = [];
        $añoActual = date('Y');

        //Hacemos un for para mostrar los ultimos 5 años
        for ($i = 0; $i < 5; $i++) {
            $año = $añoActual - $i;
            $años[] = (object)['id' => $año, 'nombre' => $año];
        }
        return $años;
    }
}