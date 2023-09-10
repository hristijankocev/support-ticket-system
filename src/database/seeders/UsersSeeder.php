<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        # Create an admin user
        User::factory()->create([
            'id' => 1,
            'name' => 'Hristijan Kocev',
            'email' => 'hko@admin.com',
            'password' => 'password',
            'role' => 'admin'
        ])->save();

        # Create agent users
        User::factory()->create([
            'id' => 2,
            'name' => 'John Doe',
            'role' => 'agent',
            'email' => 'johndoe@agent.com',
            'password' => 'password'
        ])->save();

        foreach (range(1, 4) as $ignored) {
            $email = fake()->unique()->userName() . '@agent.com';
            User::factory()->create([
                'role' => 'agent',
                'email' => $email,
                'password' => 'password'
            ]);
        }

        # Create customer users
        User::factory(30)->create([
            'password' => 'password'
        ]);
    }
}
