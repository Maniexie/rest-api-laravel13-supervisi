<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\MasterDataSeeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory;

require_once 'vendor/autoload.php';

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // User::factory(10)->create();
        $this->call([
            MasterDataSeeder::class,
            UserSeeder::class
        ]);

        // User::factory(10)->create([
        //     'name' => fake($locale = 'id_ID')->name(),
        //     'email' => fake($locale = 'id_ID')->unique()->safeEmail(),
        //     'password' => Hash::make('password'),
        // ]);
    }
}
