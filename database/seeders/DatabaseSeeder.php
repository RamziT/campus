<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            UniversiteSeeder::class,
            UfrSeeder::class,
            DepartementSeeder::class,
            FiliereSeeder::class,
            NiveauSeeder::class,
            DiplomeSeeder::class,
            NiveauDiplomeSeeder::class,
        ]);

        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'matricule' => 'MAT',
        //     'email' => 'test@example.com',
        //     'created by' => 'system'
        // ]);
    }
}
