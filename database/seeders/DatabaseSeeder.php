<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
//        User::factory()->create([
//            'admin' => true,
//        ]);

        User::factory()->count(10)->create();

        //        User::factory()->create([
        //            'name' => 'Test User',
        //            'email' => 'test@test',
        //            'password' => Hash::make('123123'),
        //            'admin' => true,
        //        ]);
    }
}
