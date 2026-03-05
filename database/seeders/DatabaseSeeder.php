<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. TRABAJADORES (9 en total)
        // 1 manager, 2 jefes técnicos, rest (6) managers o técnicos
        $trabajadoresIds = [];
        $roles = ['manager', 'jefe_tecnico', 'jefe_tecnico', 'manager', 'tecnico', 'marketing', 'marketing', 'tecnico', 'tecnico'];
        
        foreach ($roles as $index => $rol) {
            $id = DB::table('trabajadores')->insertGetId([
                'nombre' => 'Trabajador ' . ($index + 1),
                'apellido' => 'Apellido',
                'dni' => '1234567' . $index . 'T',
                'telefono' => '60000000' . $index,
                'email' => 'trabajador' . ($index + 1) . '@telcomanager.com',
                'contraseña' => Hash::make('password123'),
                'rol' => $rol,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            $trabajadoresIds[] = $id;
        }

        // 2. PRODUCTOS (10 en total)
        $productosIds = [];
        for ($i = 1; $i <= 10; $i++) {
            $id = DB::table('productos')->insertGetId([
                'nombre' => 'Producto ' . $i,
                'cantidad' => rand(10, 100),
                'precio' => rand(5, 500) + 0.99,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            $productosIds[] = $id;
        }

        // 3. TARIFAS (6 en total)
        $tarifasIds = [];
        $tiposTarifa = ['internet', 'movil', 'tv', 'tv', 'internet', 'movil'];
        foreach ($tiposTarifa as $index => $tipo) {
            $id = DB::table('tarifas')->insertGetId([
                'nombre' => 'Tarifa ' . ($index + 1),
                'tipo' => $tipo,
                'precio' => rand(10, 60),
                'descripcion' => 'Descripción de la tarifa ' . ($index + 1),
                'created_at' => now(),
                'updated_at' => now()
            ]);
            $tarifasIds[] = $id;
        }

        // 4. CLIENTES (5 en total)
        $clientesIds = [];
        for ($i = 1; $i <= 5; $i++) {
            $id = DB::table('clientes')->insertGetId([
                'nombre' => 'Cliente ' . $i,
                'apellido' => 'Apellido ' . $i,
                'dni' => '8765432' . $i . 'C',
                'telefono' => '70000000' . $i,
                'email' => 'cliente' . $i . '@ejemplo.com',
                'contraseña' => Hash::make('password123'),
                'created_at' => now(),
                'updated_at' => now()
            ]);
            $clientesIds[] = $id;
        }

        // 5. CONTRATOS (4 contratos totales)
        // Uno de los clientes debe tener 2 contratos, los demás 1. 
        // Para que sean 4 contratos totales entre 5 clientes, algunos clientes no tendrán o lo repartimos así:
        // Cliente 1 -> 2 contratos
        // Cliente 2 -> 1 contrato
        // Cliente 3 -> 1 contrato
        // Total = 4
        $contratosIds = [];
        
        // Contratos para Cliente 1
        for ($j = 0; $j < 2; $j++) {
            $id = DB::table('contratos')->insertGetId([
                'cliente_id' => $clientesIds[0],
                'trabajadore_id' => $trabajadoresIds[rand(0, 8)],
                'ciudad' => 'Ciudad A',
                'provincia' => 'Provincia A',
                'calle' => 'Calle Falsa ' . rand(1, 100),
                'numero' => rand(1, 50),
                'puerta' => 'A',
                'codigo_postal' => '2800' . rand(1, 9),
                'aprobado' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            $contratosIds[] = $id;
        }

        // Contrato para Cliente 2
        $contratosIds[] = DB::table('contratos')->insertGetId([
            'cliente_id' => $clientesIds[1],
            'trabajadore_id' => $trabajadoresIds[rand(0, 8)],
            'ciudad' => 'Ciudad B',
            'provincia' => 'Provincia B',
            'calle' => 'Calle Sol',
            'numero' => 10,
            'codigo_postal' => '41001',
            'aprobado' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Contrato para Cliente 3
        $contratosIds[] = DB::table('contratos')->insertGetId([
            'cliente_id' => $clientesIds[2],
            'trabajadore_id' => $trabajadoresIds[rand(0, 8)],
            'ciudad' => 'Ciudad C',
            'provincia' => 'Provincia C',
            'calle' => 'Calle Luna',
            'numero' => 5,
            'codigo_postal' => '29001',
            'aprobado' => false,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // 6. RELACION CONTRATO <-> TARIFA (Contrato_Tarifa)
        foreach ($contratosIds as $contratoId) {
            DB::table('contrato_tarifa')->insert([
                'contrato_id' => $contratoId,
                'tarifa_id' => $tarifasIds[rand(0, 5)],
                'fecha_inicio' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // 7. FACTURAS (7 en total)
        for ($i = 1; $i <= 7; $i++) {
            $contratoIndex = rand(0, 3);
            // Necesitamos el cliente_id asociado a ese contrato
            $contrato = DB::table('contratos')->where('id', $contratosIds[$contratoIndex])->first();
            
            DB::table('facturas')->insert([
                'cliente_id' => $contrato->cliente_id,
                'contrato_id' => $contrato->id,
                'precio' => rand(30, 100) + 0.50,
                'fecha_inicio' => Carbon::now()->subMonths($i),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // 8. INCIDENCIAS (5 en total)
        for ($i = 0; $i < 5; $i++) {
            DB::table('incidencias')->insert([
                'cliente_id' => $clientesIds[rand(0, 4)],
                'trabajador_id' => $trabajadoresIds[rand(0, 8)],
                'descripcion' => 'Problema técnico número ' . ($i + 1),
                'estado' => ['abierto', 'en_progreso', 'cerrado'][rand(0, 2)],
                'fecha' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        
        // 9. RELACION TARIFA <-> PRODUCTO (Tarifa_Producto)
        foreach ($tarifasIds as $tarifaId) {
            // Cada tarifa tiene al menos 1 producto aleatorio
            DB::table('tarifa_producto')->insert([
                'tarifa_id' => $tarifaId,
                'producto_id' => $productosIds[rand(0, 9)]
            ]);
        }
    }//php artisan db:seed --class=DatabaseSeeder
}