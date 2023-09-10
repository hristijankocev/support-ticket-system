<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
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

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->word()
        ];
    }
}
