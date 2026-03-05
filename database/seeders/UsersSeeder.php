<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    public function run()
    {
        // CLIENTE
        DB::table('clientes')->insert([
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'dni' => '12345678A',
            'telefono' => '600111222',
            'email' => 'cliente@example.com',
            'contraseña' => Hash::make('cliente123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // TRABAJADORES
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

        // TARIFAS
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
        ]);

        // PRODUCTOS
        DB::table('productos')->insert([
            [
                'nombre' => 'Router Wifi 6',
                'cantidad' => 10,
                'precio' => 59.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Extensor de Red',
                'cantidad' => 15,
                'precio' => 29.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
//php artisan db:seed --class=UsersSeeder