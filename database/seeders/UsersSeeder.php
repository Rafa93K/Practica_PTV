<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UsersSeeder extends Seeder
{
    public function run()
    {
        // Limpiar tablas para evitar duplicados si se corre sin refresh (aunque el usuario pidió el comando completo)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('clientes')->truncate();
        DB::table('trabajadores')->truncate();
        DB::table('tarifas')->truncate();
        DB::table('productos')->truncate();
        DB::table('contratos')->truncate();
        DB::table('contrato_tarifa')->truncate();
        DB::table('facturas')->truncate();
        DB::table('incidencias')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // -------------------------
        // CLIENTES (15 clientes)
        // -------------------------
        $nombres = ['Juan', 'María', 'Pedro', 'Ana', 'Carlos', 'Laura', 'Diego', 'Elena', 'Sofía', 'Javier', 'Lucía', 'Marcos', 'Carmen', 'Raúl', 'Isabel'];
        $apellidos = ['Pérez', 'García', 'López', 'Martínez', 'Sánchez', 'Gómez', 'Rodríguez', 'Fernández', 'Ruiz', 'Díaz', 'Morales', 'Ortega', 'Navarro', 'Torres', 'Ramírez'];

        for ($i = 1; $i <= 15; $i++) {
            DB::table('clientes')->insert([
                'id' => $i,
                'nombre' => $nombres[$i-1],
                'apellido' => $apellidos[$i-1],
                'dni' => str_pad($i, 8, '0', STR_PAD_LEFT) . chr(64 + ($i % 26)),
                'telefono' => '600' . str_pad($i, 6, '0', STR_PAD_LEFT),
                'email' => 'cliente' . $i . '@example.com',
                'contraseña' => Hash::make('cliente123'),
                'created_at' => now()->subDays(rand(1, 100)),
                'updated_at' => now(),
            ]);
        }

        // -------------------------
        // TRABAJADORES
        // -------------------------
        $trabajadores = [
            ['nombre' => 'Admin', 'apellido' => 'Manager', 'dni' => '11111111B', 'telefono' => '600111111', 'email' => 'manager@example.com', 'contraseña' => 'manager123', 'rol' => 'manager'],
            ['nombre' => 'Marta', 'apellido' => 'Marketing', 'dni' => '22222222C', 'telefono' => '600222222', 'email' => 'marketing@example.com', 'contraseña' => 'marketing123', 'rol' => 'marketing'],
            ['nombre' => 'Alberto', 'apellido' => 'Jefe', 'dni' => '33333333D', 'telefono' => '600333333', 'email' => 'jefetecnico@example.com', 'contraseña' => 'jefetecnico123', 'rol' => 'jefe_tecnico'],
            ['nombre' => 'Carlos', 'apellido' => 'Técnico 1', 'dni' => '44444444E', 'telefono' => '600444444', 'email' => 'tecnico@example.com', 'contraseña' => 'tecnico123', 'rol' => 'tecnico'],
            ['nombre' => 'Sofía', 'apellido' => 'Técnico 2', 'dni' => '55555555F', 'telefono' => '600555555', 'email' => 'tecnico2@example.com', 'contraseña' => 'tecnico123', 'rol' => 'tecnico'],
        ];

        foreach ($trabajadores as $trab) {
            DB::table('trabajadores')->insert([
                'nombre' => $trab['nombre'],
                'apellido' => $trab['apellido'],
                'dni' => $trab['dni'],
                'telefono' => $trab['telefono'],
                'email' => $trab['email'],
                'contraseña' => Hash::make($trab['contraseña']),
                'rol' => $trab['rol'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // -------------------------
        // TARIFAS (Más variedad)
        // -------------------------
        $tarifasData = [
            ['Internet 100Mb', 'internet', 29.99, 'Conexión de alta velocidad 100Mb simétrica.'],
            ['Internet 600Mb', 'internet', 39.99, 'Fibra de alta velocidad ideal para gaming y streaming.'],
            ['Internet 1Gb', 'internet', 49.99, 'La máxima velocidad disponible en el mercado.'],
            ['Móvil Básico 10GB', 'movil', 9.99, '10GB de datos y llamadas ilimitadas.'],
            ['Móvil Pro 50GB', 'movil', 19.99, '50GB de datos con velocidad 5G.'],
            ['Móvil Ilimitado', 'movil', 24.99, 'Llamadas y datos ilimitados sin restricciones.'],
            ['Televisión Esencial', 'tv', 10.00, 'Más de 50 canales temáticos en HD.'],
            ['Televisión Premium', 'tv', 20.00, 'Cine, series y todo el deporte en 4K.'],
        ];

        foreach ($tarifasData as $t) {
            DB::table('tarifas')->insert([
                'nombre' => $t[0],
                'tipo' => $t[1],
                'precio' => $t[2],
                'descripcion' => $t[3],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // -------------------------
        // PRODUCTOS (Inventario)
        // -------------------------
        $productosData = [
            ['Router Wifi 6', 50, 45.00],
            ['Extensor de Red Mesh', 30, 60.00],
            ['Cable Ethernet CAT7 10m', 100, 5.50],
            ['Decodificador Android TV', 40, 35.00],
            ['Tarjeta SIM 5G', 200, 1.00],
        ];

        foreach ($productosData as $p) {
            DB::table('productos')->insert([
                'nombre' => $p[0],
                'cantidad' => $p[1],
                'precio' => $p[2],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // -------------------------
        // CONTRATOS (Varios contratos por cliente)
        // -------------------------
        $ciudades = ['Madrid', 'Barcelona', 'Sevilla', 'Valencia', 'Málaga', 'Zaragoza', 'Bilbao', 'Alicante'];
        $vias = ['Calle', 'Avenida', 'Paseo', 'Plaza'];
        
        for ($i = 1; $i <= 15; $i++) {
            // Cada cliente tiene al menos 1 contrato, algunos 2
            $numContratos = rand(1, 2);
            for ($j = 0; $j < $numContratos; $j++) {
                $contratoId = DB::table('contratos')->insertGetId([
                    'cliente_id' => $i,
                    'trabajador_id' => rand(1, 2), // Asignado a manager o marketing
                    'ciudad' => $ciudades[array_rand($ciudades)],
                    'provincia' => 'Provincia Test',
                    'calle' => $vias[array_rand($vias)] . ' de la Prueba ' . rand(1, 100),
                    'numero' => rand(1, 50),
                    'puerta' => rand(1, 9) . (rand(0, 1) ? 'A' : 'B'),
                    'codigo_postal' => str_pad(rand(1000, 52000), 5, '0', STR_PAD_LEFT),
                    'created_at' => now()->subMonths(rand(1, 6)),
                    'updated_at' => now(),
                ]);

                // Asignar 1 o 2 tarifas al contrato
                $numTarifas = rand(1, 2);
                $tarifasIds = range(1, 8);
                shuffle($tarifasIds);
                $misTarifas = array_slice($tarifasIds, 0, $numTarifas);

                foreach ($misTarifas as $tarifaId) {
                    $precioTarifa = DB::table('tarifas')->where('id', $tarifaId)->value('precio');
                    
                    DB::table('contrato_tarifa')->insert([
                        'contrato_id' => $contratoId,
                        'tarifa_id' => $tarifaId,
                        'fecha_inicio' => Carbon::now()->subMonths(rand(1, 5))->toDateString(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    // Generar algunas facturas para este contrato
                    for ($m = 0; $m < rand(1, 3); $m++) {
                        DB::table('facturas')->insert([
                            'cliente_id' => $i,
                            'contrato_id' => $contratoId,
                            'precio' => $precioTarifa,
                            'fecha_inicio' => Carbon::now()->subMonths($m)->startOfMonth()->toDateString(),
                            'created_at' => now()->subMonths($m),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        }

        // -------------------------
        // INCIDENCIAS (Muchos datos para los técnicos)
        // -------------------------
        $descripciones = [
            'No funciona el internet desde esta mañana.',
            'El teléfono móvil no tiene cobertura en casa.',
            'Fallo en el decodificador de TV, pantalla negra.',
            'La velocidad de la fibra es muy baja.',
            'Problema con el cobro de la última factura.',
            'Duda sobre el roaming en mi tarifa móvil.',
            'Necesito un extensor de red para la planta de arriba.',
            'Mi router se reinicia solo cada 10 minutos.',
            'No puedo enviar SMS desde mi terminal.',
            'La conexión se corta cuando llueve.'
        ];

        $estados = ['pendiente', 'en_progreso', 'cerrado'];
        $tecnicosIds = [4, 5]; // Carlos y Sofía

        for ($i = 0; $i < 40; $i++) {
            $estado = $estados[array_rand($estados)];
            $tecnico = (rand(0, 10) > 2) ? $tecnicosIds[array_rand($tecnicosIds)] : null; // Algunas sin asignar
            
            DB::table('incidencias')->insert([
                'cliente_id' => rand(1, 15),
                'trabajador_id' => $tecnico,
                'descripcion' => $descripciones[array_rand($descripciones)],
                'estado' => $estado,
                'fecha_inicio' => Carbon::now()->subDays(rand(1, 60))->toDateString(),
                'fecha_fin' => Carbon::now()->subDays(rand(0, 60))->toDateString(),
                'intervalo_resolucion' => rand(1, 60),
                'created_at' => now()->subDays(rand(1, 60)),
                'updated_at' => ($estado == 'cerrado' || $estado == 'en_progreso') ? now()->subDays(rand(0, 30)) : now(),
            ]);
        }
    }
}