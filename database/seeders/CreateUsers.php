<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreateUsers extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'admin@pointsystem.pt',
                'password' => bcrypt('abc123456'),
                'role' => 'admin',
                'position' => 'Administrador',
                'status' => 'Ativo',
                'created_at' => now()
            ],
            [
                'name' => 'Tiago Dores',
                'email' => 'tiago.dores@pointsystem.pt',
                'password' => bcrypt('abc123456'),
                'role' => 'manager',
                'position' => 'Gerente',
                'status' => 'Ativo',
                'created_at' => now()
            ],
            [
                'name' => 'David Silva',
                'email' => 'david.silva@pointsystem.pt',
                'password' => bcrypt('abc123456'),
                'role' => 'employee',
                'position' => 'Operador',
                'status' => 'Ativo',
                'created_at' => now()
            ],
            [
                'name' => 'Rui Fernandes',
                'email' => 'rui.fernandes@pointsystem.pt',
                'password' => bcrypt('abc123456'),
                'role' => 'manager',
                'position' => 'Gerente',
                'status' => 'Ativo',
                'created_at' => now()
            ],
            [
                'name' => 'Sofia Almeida',
                'email' => 'sofia.almeida@pointsystem.pt',
                'password' => bcrypt('abc123456'),
                'role' => 'manager',
                'position' => 'Gerente',
                'status' => 'Ativo',
                'created_at' => now()
            ],
            [
                'name' => 'Miguel Pacheco',
                'email' => 'miguel.pacheco@pointsystem.pt',
                'password' => bcrypt('abc123456'),
                'role' => 'employee',
                'position' => 'Operador',
                'status' => 'Ativo',
                'created_at' => now()
            ],
            [
                'name' => 'Inês Martins',
                'email' => 'ines.martins@pointsystem.pt',
                'password' => bcrypt('abc123456'),
                'role' => 'employee',
                'position' => 'Operador',
                'status' => 'Ativo',
                'created_at' => now()
            ],
            [
                'name' => 'Bruno Teixeira',
                'email' => 'bruno.teixeira@pointsystem.pt',
                'password' => bcrypt('abc123456'),
                'role' => 'employee',
                'position' => 'Operador',
                'status' => 'Inativo',
                'created_at' => now()
            ],
            [
                'name' => 'Carla Lopes',
                'email' => 'carla.lopes@pointsystem.pt',
                'password' => bcrypt('abc123456'),
                'role' => 'employee',
                'position' => 'Operador',
                'status' => 'Ativo',
                'created_at' => now()
            ]
        ]);
    }
}
