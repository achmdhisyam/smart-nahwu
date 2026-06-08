<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test Santri',
            'email' => 'santri@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'santri',
        ]);

        User::factory()->create([
            'name' => 'Test Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->call([
            JurumiyahSeeder::class,
            PencapaianSeeder::class,
        ]);
    }
}
