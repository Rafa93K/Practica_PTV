<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class MarketingService
{
    public function obtenerDatos()
    {
        $totalContratos = DB::table('contratos')->count();
        
        $producido = DB::table('facturas')->sum('precio');
        $invertido = DB::table('productos')->selectRaw('SUM(cantidad * precio) as total')->value('total');
        $beneficio = $producido - $invertido;

        // TARIFAS MÁS CONTRATADAS
        $tarifasMasContratadas = DB::table('contrato_tarifa')
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

        return [
            'totalContratos' => $totalContratos,
            'producido' => $producido,
            'invertido' => $invertido,
            'beneficio' => $beneficio,

            // datos del gráfico
            'tarifasLabels' => $tarifasLabels,
            'tarifasData' => $tarifasData
        ];
    }
}