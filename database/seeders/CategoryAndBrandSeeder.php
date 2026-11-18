<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoryAndBrandSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Rotor Assemblies', 'order' => 1],
            ['name' => 'Cartridges (CHRA)', 'order' => 2],
            ['name' => 'Nozzle Rings & Shrouds', 'order' => 3],
            ['name' => 'Bearings & Seals', 'order' => 4],
            ['name' => 'Turbine Blading', 'order' => 5],
            ['name' => 'Compressor Impellers', 'order' => 6],
            ['name' => 'Casing & Liners', 'order' => 7],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(
                ['name' => $cat['name']],
                [
                    'slug'      => Str::slug($cat['name']),
                    'order'     => $cat['order'],
                    'is_active' => true,
                ]
            );
        }

        $brands = [
            ['name' => 'MAN Energy Solutions', 'order' => 1],
            ['name' => 'ABB / Accelleron', 'order' => 2],
            ['name' => 'Mitsubishi Heavy Industries (MHI)', 'order' => 3],
            ['name' => 'Napier Turbochargers', 'order' => 4],
            ['name' => 'KBB Turbochargers', 'order' => 5],
            ['name' => 'Garrett / Honeywell', 'order' => 6],
        ];

        foreach ($brands as $brand) {
            Brand::firstOrCreate(
                ['name' => $brand['name']],
                [
                    'slug'      => Str::slug($brand['name']),
                    'order'     => $brand['order'],
                    'is_active' => true,
                ]
            );
        }

        // Link existing products to category_id and brand_id
        foreach (Product::all() as $product) {
            $catName = $product->technical_specifications['category'] ?? null;
            $brandName = $product->technical_specifications['brand'] ?? null;

            $catId = $catName ? Category::where('name', $catName)->value('id') : null;
            $brandId = $brandName ? Brand::where('name', $brandName)->value('id') : null;

            if ($catId || $brandId) {
                $product->update([
                    'category_id' => $catId ?? $product->category_id,
                    'brand_id'    => $brandId ?? $product->brand_id,
                ]);
            }
        }
    }
}
