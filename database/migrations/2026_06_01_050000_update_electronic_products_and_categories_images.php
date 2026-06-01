<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Category;
use App\Models\Product;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $mapping = [
            'Smartphones & Accesorios' => 'shop/electronics/category_smartphones.png',
            'Computadoras & Laptops' => 'shop/electronics/category_computers.png',
            'Audio & Sonido' => 'shop/electronics/category_audio.png',
            'Smart TVs & Entretenimiento' => 'shop/electronics/category_tvs.png',
            'Wearables & Gadgets' => 'shop/electronics/category_wearables.png',
        ];

        foreach ($mapping as $catName => $imagePath) {
            $category = Category::where('name', $catName)->first();
            if ($category) {
                // Update Category image
                $category->image_path = $imagePath;
                $category->save();

                // Update all products in this category to use the same matching professional mockup image
                Product::where('category_id', $category->id)->update([
                    'image_path' => $imagePath
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $mapping = [
            'Smartphones & Accesorios',
            'Computadoras & Laptops',
            'Audio & Sonido',
            'Smart TVs & Entretenimiento',
            'Wearables & Gadgets',
        ];

        foreach ($mapping as $catName) {
            $category = Category::where('name', $catName)->first();
            if ($category) {
                $category->image_path = null;
                $category->save();

                Product::where('category_id', $category->id)->update([
                    'image_path' => null
                ]);
            }
        }
    }
};
