<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Project;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ServiceSeeder::class,
            SectorSeeder::class,
            BlogSeeder::class,
            AdvantageSeeder::class,
            TeamSeeder::class,
            PartnerSeeder::class,
            ProjectSeeder::class,
            ImageSeeder::class,
            ContactSeeder::class,
            StatisticSeeder::class,
            TextSeeder::class,
        ]);
        // User::factory(10)->create();

//        User::factory()->create([
//            'name' => 'Test User',
//            'email' => 'test@example.com',
//        ]);
    }
}
