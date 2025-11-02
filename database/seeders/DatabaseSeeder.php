<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            'Sobremesas',
            'Massas',
            'Carnes',
            'Peixes',
            'Aves',
            'Saladas',
            'Sopas',
            'Lanches',
            'Bebidas',
            'Vegetarianos',
        ];

        foreach ($categorias as $nome) {
            Categoria::firstOrCreate(['nome' => $nome]);
        }
    }
}
