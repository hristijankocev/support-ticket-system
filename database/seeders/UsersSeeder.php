<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        # Create customer users
        User::factory(30)->create();

        # Create agent users
        User::factory(5)->create([
            'role' => 'agent'
        ]);

        # Create an admin user
        User::factory()->create([
            'name' => 'Hristijan Kocev',
            'email' => 'hko@admin.com',
            'password' => 'password',
            'role' => 'admin'
        ]);
    }
}
