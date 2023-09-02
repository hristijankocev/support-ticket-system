<?php

namespace Database\Factories;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends Factory<Ticket>
 */
class TicketFactory extends Factory
{
    public static array $severities = [
        'low',
        'medium',
        'major',
        'critical'
    ];

    public static array $statuses = [
        'open',
        'in-progress',
        'resolved',
        'closed'
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        /** @noinspection RandomApiMigrationInspection */
        return [
            'category_id' => mt_rand(1, count(CategoryFactory::$categories) - 1),
            'user_id' => DB::table('users')
                ->where('role', '=', 'client')
                ->inRandomOrder()
                ->first()->id,
            'agent_id' => DB::table('users')
                ->inRandomOrder()
                ->where('role', '=', 'agent')
                ->first()->id,
            'title' => fake()->sentence(3),
            'body' => fake()->paragraph(3, true),
            'severity' => self::$severities[mt_rand(0, count(self::$severities) - 1)],
            'status' => self::$statuses[mt_rand(0, count(self::$statuses) - 1)]
        ];
    }
}
