<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('trabajadores')->insert([
            'nombre' => 'Manager',
            'apellido' => 'Empresa',
            'dni' => '12345678M',
            'telefono' => '600000000',
            'email' => 'juan@empresa.com',
            'contraseña' => Hash::make('12345678M'), 
            'rol' => 'manager',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
    //php artisan db:seed --class=UsersSeeder
}
