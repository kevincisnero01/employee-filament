<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Country;
use App\Models\Department;
use App\Models\State;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'country_id' => Country::all()->random()->id,
            'state_id' =>  State::all()->random()->id,
            'city_id' =>  City::all()->random()->id,
            'department_id' =>  Department::all()->random()->id,
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'address' => fake()->address(),
            'phone_number' => fake()->phoneNumber(),
            'zip_code' => fake()->postcode(),
            'birth_date' => fake()->date(),
            'date_hired' => fake()->date(),
        ];
    }
}
