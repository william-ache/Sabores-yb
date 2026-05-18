<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Asegurar que exista la carpeta public/products en storage
        $storageDir = storage_path('app/public/products');
        if (!file_exists($storageDir)) {
            mkdir($storageDir, 0755, true);
        }

        // Copiar las imágenes reales desde public/images/empanadas/ a storage/app/public/products/
        $sourceDir = public_path('images/empanadas');
        if (file_exists($sourceDir)) {
            $files = scandir($sourceDir);
            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..') {
                    $sourceFile = $sourceDir . '/' . $file;
                    $destFile = $storageDir . '/' . $file;
                    copy($sourceFile, $destFile);
                }
            }
        }

        // --- Empanadas Clásicas ---
        $clasicas = Category::where('name', 'Empanadas Clásicas')->first();
        if ($clasicas) {
            $productsClasicas = [
                [
                    'title' => 'Carne Mechada',
                    'description' => 'Jugosa carne de res desmechada y sazonada con el toque tradicional venezolano.',
                    'price' => 1.5,
                    'category_id' => $clasicas->id,
                    'image_path' => 'products/carne_mechada.png',
                    'is_active' => true,
                    'sort_order' => 0,
                ],
                [
                    'title' => 'Jamón con Queso',
                    'description' => 'La combinación perfecta de jamón de primera y queso fundido irresistible.',
                    'price' => 1.5,
                    'category_id' => $clasicas->id,
                    'image_path' => 'products/jamon_queso.png',
                    'is_active' => true,
                    'sort_order' => 1,
                ],
                [
                    'title' => 'Pollo',
                    'description' => 'Pechuga de pollo desmenuzada y guisada con vegetales frescos.',
                    'price' => 1.5,
                    'category_id' => $clasicas->id,
                    'image_path' => 'products/pollo.png',
                    'is_active' => true,
                    'sort_order' => 2,
                ],
                [
                    'title' => 'Carne Molida',
                    'description' => 'Carne molida de res sazonada a la perfección, un clásico que nunca falla.',
                    'price' => 1.5,
                    'category_id' => $clasicas->id,
                    'image_path' => 'products/carne_molida.png',
                    'is_active' => true,
                    'sort_order' => 3,
                ],
                [
                    'title' => 'Queso blanco (Llanero)',
                    'description' => 'Tradicional queso llanero derretido dentro de una masa crujiente.',
                    'price' => 1.5,
                    'category_id' => $clasicas->id,
                    'image_path' => 'products/queso_blanco.png',
                    'is_active' => true,
                    'sort_order' => 4,
                ],
                [
                    'title' => 'Pabellón',
                    'description' => 'El sabor de Venezuela: carne mechada, caraotas negras y queso blanco.',
                    'price' => 1.5,
                    'category_id' => $clasicas->id,
                    'image_path' => 'products/pabellon.png',
                    'is_active' => true,
                    'sort_order' => 5,
                ],
                [
                    'title' => 'Guiso Navideño',
                    'description' => 'Todo el sabor de la hallaca en una empanada crujiente y deliciosa.',
                    'price' => 1.5,
                    'category_id' => $clasicas->id,
                    'image_path' => 'products/navideno.png',
                    'is_active' => true,
                    'sort_order' => 6,
                ],
                [
                    'title' => 'Macabí (Pescado)',
                    'description' => 'Delicioso guiso de pescado Macabí, fresco y con el sabor del mar.',
                    'price' => 1.5,
                    'category_id' => $clasicas->id,
                    'image_path' => 'products/macabi.png',
                    'is_active' => true,
                    'sort_order' => 7,
                ],
            ];

            foreach ($productsClasicas as $product) {
                Product::updateOrCreate(['title' => $product['title']], $product);
            }
        }

        // --- Empanadas Especiales ---
        $especiales = Category::where('name', 'Empanadas Especiales')->first();
        if ($especiales) {
            $productsEspeciales = [
                [
                    'title' => 'Mechada con Queso (Pelúa)',
                    'description' => 'La famosa "Pelúa": carne mechada tierna con abundante queso amarillo rallado.',
                    'price' => 1.8,
                    'category_id' => $especiales->id,
                    'image_path' => 'products/pelua.png',
                    'is_active' => true,
                    'sort_order' => 0,
                ],
                [
                    'title' => 'Molida con Queso',
                    'description' => 'Deliciosa carne molida sazonada combinada con el toque cremoso del queso.',
                    'price' => 1.8,
                    'category_id' => $especiales->id,
                    'image_path' => 'products/molida_queso.png',
                    'is_active' => true,
                    'sort_order' => 1,
                ],
                [
                    'title' => 'Pollo con Queso (Catira)',
                    'description' => 'La clásica "Catira": pollo bien guisado con generoso queso amarillo.',
                    'price' => 1.8,
                    'category_id' => $especiales->id,
                    'image_path' => 'products/catira.png',
                    'is_active' => true,
                    'sort_order' => 2,
                ],
                [
                    'title' => 'Gordon Blue de Mechada',
                    'description' => 'Una explosión de sabor: carne mechada rellena de jamón y queso fundido.',
                    'price' => 1.8,
                    'category_id' => $especiales->id,
                    'image_path' => 'products/gordon_blue_mechada.png',
                    'is_active' => true,
                    'sort_order' => 3,
                ],
                [
                    'title' => 'Gordon Blue de Pollo',
                    'description' => 'Pechuga de pollo rellena de jamón y queso, una delicia gourmet.',
                    'price' => 1.8,
                    'category_id' => $especiales->id,
                    'image_path' => 'products/gordon_blue_pollo.png',
                    'is_active' => true,
                    'sort_order' => 4,
                ],
            ];

            foreach ($productsEspeciales as $product) {
                Product::updateOrCreate(['title' => $product['title']], $product);
            }
        }
    }
}
