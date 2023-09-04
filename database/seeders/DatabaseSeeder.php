<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Kevin SuperDuperDev',
            'email' => 'developer@gmail.com',
        ]);

        $role = Role::create(['name' => 'Administrador']);
        $user->assignRole($role);


        $user2 = User::factory()->create([
            'name' => 'User Test',
            'email' => 'test@gmail.com',
        ]);

        $role2 = Role::create(['name' => 'Empleado']);
        $user2->assignRole($role2);

        \App\Models\Country::factory(12)->create();

        \App\Models\State::factory(12)->create();

        \App\Models\City::factory(12)->create();

        \App\Models\Department::factory(12)->create();

        \App\Models\Employee::factory(12)->create();

    }
}
