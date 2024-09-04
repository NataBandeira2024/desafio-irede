<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    public function run()
    {
        $categorias = [
            ['nome' => 'Tecnologia'],
            ['nome' => 'Alimentos'],
            ['nome' => 'Vestuário'],
            ['nome' => 'Móveis'],
            ['nome' => 'Eletrônicos'],
        ];

        foreach ($categorias as $categoria) {
            Categoria::create($categoria);
        }
    }
}
