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
        // -------------------------
        // CLIENTES
        // -------------------------
        DB::table('clientes')->insert([
            [
                'nombre' => 'Juan',
                'apellido' => 'Pérez',
                'dni' => '12345678A',
                'telefono' => '600111222',
                'email' => 'cliente1@example.com',
                'contraseña' => Hash::make('cliente123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'María',
                'apellido' => 'García',
                'dni' => '23456789B',
                'telefono' => '600222333',
                'email' => 'cliente2@example.com',
                'contraseña' => Hash::make('cliente123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Pedro',
                'apellido' => 'López',
                'dni' => '34567890C',
                'telefono' => '600333444',
                'email' => 'cliente3@example.com',
                'contraseña' => Hash::make('cliente123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // -------------------------
        // TRABAJADORES
        // -------------------------
        $trabajadores = [
            ['nombre' => 'Laura', 'apellido' => 'Gómez', 'dni' => '11111111B', 'telefono' => '600111111', 'email' => 'manager@example.com', 'contraseña' => 'manager123', 'rol' => 'manager'],
            ['nombre' => 'Mario', 'apellido' => 'López', 'dni' => '22222222C', 'telefono' => '600222222', 'email' => 'marketing@example.com', 'contraseña' => 'marketing123', 'rol' => 'marketing'],
            ['nombre' => 'Ana', 'apellido' => 'Martínez', 'dni' => '33333333D', 'telefono' => '600333333', 'email' => 'jefetecnico@example.com', 'contraseña' => 'jefetecnico123', 'rol' => 'jefe_tecnico'],
            ['nombre' => 'Carlos', 'apellido' => 'Ruiz', 'dni' => '44444444E', 'telefono' => '600444444', 'email' => 'tecnico@example.com', 'contraseña' => 'tecnico123', 'rol' => 'tecnico'],
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
        // TARIFAS
        // -------------------------
        DB::table('tarifas')->insert([
            [
                'nombre' => 'Internet 100Mb',
                'tipo' => 'internet',
                'precio' => 29.99,
                'descripcion' => 'Conexión de alta velocidad 100Mb simétrica.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Movil Ilimitado',
                'tipo' => 'movil',
                'precio' => 19.99,
                'descripcion' => 'Llamadas y datos ilimitados en toda España.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Televisión HD',
                'tipo' => 'tv',
                'precio' => 15.99,
                'descripcion' => 'Canales HD y grabador digital.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // -------------------------
        // PRODUCTOS
        // -------------------------
        DB::table('productos')->insert([
            [
                'nombre' => 'Router Wifi 6',
                'cantidad' => 10,
                'precio' => 5.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Extensor de Red',
                'cantidad' => 15,
                'precio' => 7.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Cable Ethernet',
                'cantidad' => 50,
                'precio' => 1.5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // -------------------------
        // CONTRATOS
        // -------------------------
        DB::table('contratos')->insert([
            [
                'cliente_id' => 1,
                'trabajadore_id' => 1,
                'ciudad' => 'Madrid',
                'provincia' => 'Madrid',
                'calle' => 'Calle Mayor',
                'numero' => 12,
                'puerta' => '3A',
                'codigo_postal' => '28013',
                'aprobado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cliente_id' => 2,
                'trabajadore_id' => 2,
                'ciudad' => 'Barcelona',
                'provincia' => 'Barcelona',
                'calle' => 'Passeig de Gràcia',
                'numero' => 45,
                'puerta' => '5B',
                'codigo_postal' => '08007',
                'aprobado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cliente_id' => 3,
                'trabajadore_id' => 3,
                'ciudad' => 'Sevilla',
                'provincia' => 'Sevilla',
                'calle' => 'Calle Sierpes',
                'numero' => 8,
                'puerta' => null,
                'codigo_postal' => '41004',
                'aprobado' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // -------------------------
        // CONTRATO-TARIFA
        // -------------------------
        DB::table('contrato_tarifa')->insert([
            [
                'contrato_id' => 1,
                'tarifa_id' => 1,
                'fecha_inicio' => Carbon::now()->subMonths(3)->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'contrato_id' => 2,
                'tarifa_id' => 2,
                'fecha_inicio' => Carbon::now()->subMonths(2)->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'contrato_id' => 3,
                'tarifa_id' => 3,
                'fecha_inicio' => Carbon::now()->subMonth()->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // -------------------------
        // FACTURAS
        // -------------------------
        DB::table('facturas')->insert([
            [
                'cliente_id' => 1,
                'contrato_id' => 1,
                'precio' => 29.99,
                'fecha_inicio' => Carbon::now()->subMonths(3)->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cliente_id' => 2,
                'contrato_id' => 2,
                'precio' => 19.99,
                'fecha_inicio' => Carbon::now()->subMonths(2)->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cliente_id' => 3,
                'contrato_id' => 3,
                'precio' => 15.99,
                'fecha_inicio' => Carbon::now()->subMonth()->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // -------------------------
        // INCIDENCIAS
        // -------------------------
        DB::table('incidencias')->insert([
            [
                'cliente_id' => 1,
                'trabajador_id' => 4,
                'descripcion' => 'Fallo de conexión',
                'estado' => 'abierto',
                'fecha' => Carbon::now()->subDays(5)->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cliente_id' => 2,
                'trabajador_id' => 4,
                'descripcion' => 'Problema con factura',
                'estado' => 'en_progreso',
                'fecha' => Carbon::now()->subDays(3)->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cliente_id' => 3,
                'trabajador_id' => null,
                'descripcion' => 'Consulta general',
                'estado' => 'cerrado',
                'fecha' => Carbon::now()->subDays(1)->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
//php artisan db:seed --class=UsersSeeder
//php artisan migrate:fresh