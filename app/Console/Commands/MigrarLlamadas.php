<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Contrato;
use App\Models\Factura;

class MigrarLlamadas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrar:llamadas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crear facturas de los contratos de los clientes cada mes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Obtenemos todos los contratos junto con sus tarifas asociadas
        $contratos = Contrato::with('tarifas')->get();

        $facturasCreadas = 0;

        foreach ($contratos as $contrato) {
            // Sumamos el precio de todas las tarifas vinculadas al contrato
            $precioTotal = $contrato->tarifas->sum('precio');

            // Solo facturamos si el precio es mayor a 0 (hay tarifas contratadas)
            if ($precioTotal > 0) {
                Factura::create([
                    'cliente_id' => $contrato->cliente_id,
                    'contrato_id' => $contrato->id,
                    'precio' => $precioTotal,
                    'fecha_inicio' => now(),
                ]);
                $facturasCreadas++;
            }
        }

        $this->info("Proceso completado. Se han generado {$facturasCreadas} facturas exitosamente.");
    }
}
