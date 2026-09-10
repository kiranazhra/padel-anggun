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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'phone' => '081200000000',
            'password' => bcrypt('admin123'),
            'is_admin' => true,
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '081211111111',
            'password' => bcrypt('password'),
            'is_admin' => false,
        ]);

        $this->call(CoachSeeder::class);
        $this->call(PromoSeeder::class);
        $this->call(CourtSeeder::class);
        $this->call(ReservationSeeder::class);
    }
}
