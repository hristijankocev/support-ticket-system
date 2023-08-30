<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public static array $categories = [
        'technical',
        'billing and payments',
        'product information',
        'feature requests',
        'feedback and complaints',
        'training and documentation',
        'account security',
        'performance issues',
    ];

    public function run(): void
    {
        foreach (self::$categories as $category) {
            Category::factory()->create([
                'name' => $category
            ]);
        }
    }
}
