<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'image' => "employees/placeholder.png",
            'phone_number' => "09" . $this->faker->numerify('########'),
            'email' => $this->faker->unique()->safeEmail,
        ];
    }
}
