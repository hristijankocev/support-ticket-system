<?php

namespace Database\Seeders;

use App\Models\Category;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        foreach (CategoryFactory::$categories as $category) {
            Category::factory()->create([
                'name' => $category
            ]);
        }
    }
}
