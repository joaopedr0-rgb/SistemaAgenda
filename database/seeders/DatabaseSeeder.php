<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name'      => 'Administrador do Salão',
            'email'     => 'admin@salao.com',
            'password'  => bcrypt('admin123'),
            'is_admin'  => 1, // <--- Aqui definimos que ele é Admin (1 = true)
            'cep'       => '00000000',
            'bairro'    => 'Centro',
            'cidade'    => 'Cidade Teste',
            'estado'    => 'SP',
            'logradouro'=> 'Rua de Teste',
            'numero'    => '123',
        ]);
    }
}
