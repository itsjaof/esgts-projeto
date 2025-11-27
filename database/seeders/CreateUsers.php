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
                'name' => 'Tiago Dores',
                'email' => 'tiagodores@gmail.com',
                'password' => bcrypt('abc123456'),
                'role' => 'admin',
                'position' => 'Administrador',
                'status' => 'Ativo',
                'created_at' => now()
            ],
            [
                'name' => 'João Quitério',
                'email' => 'joaoquiterio@gmail.com',
                'password' => bcrypt('abc123456'),
                'role' => 'admin',
                'position' => 'Administrador',
                'status' => 'Ativo',
                'created_at' => now()
            ]
        ]);
    }
}
