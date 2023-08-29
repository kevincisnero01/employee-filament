<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(1)->create([
            'name' => 'Kevin SuperDuperDev',
            'email' => 'developer@gmail.com',
        ]);

        \App\Models\Country::factory(12)->create();

        \App\Models\State::factory(12)->create();

        \App\Models\City::factory(12)->create();

        \App\Models\Department::factory(12)->create();

        \App\Models\Employee::factory(12)->create();

    }
}
