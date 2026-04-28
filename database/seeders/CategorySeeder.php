<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Empanadas Clásicas',
                'description' => 'Nuestros sabores tradicionales con el toque clásico de la casa.',
                'icon' => 'fas fa-fire',
                'color' => '#00a859',
                'sort_order' => 0,
                'is_active' => true,
            ],
            [
                'name' => 'Empanadas Especiales',
                'description' => 'Combinaciones únicas y sabores gourmet para paladares exigentes.',
                'icon' => 'fas fa-star',
                'color' => '#e71d36',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Refrescos y Jugos',
                'description' => 'Bebidas refrescantes para acompañar tu comida favorita.',
                'icon' => 'fas fa-glass-water',
                'color' => '#2ec4b6',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Chucherías y Dulces',
                'description' => 'El toque dulce que necesitas después de una buena empanada.',
                'icon' => 'fas fa-candy-cane',
                'color' => '#f472b6',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Artículos de Conveniencia',
                'description' => 'Todo lo básico que necesitas a la mano en un solo lugar.',
                'icon' => 'fas fa-shopping-basket',
                'color' => '#818cf8',
                'sort_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['name' => $category['name']],
                $category
            );
        }
    }
}
