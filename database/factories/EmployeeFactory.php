<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\EmployeePosition;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'position_id' => EmployeePosition::query()->inRandomOrder()->limit(1)->pluck('id')[0],
            'start_date' => $this->faker->dateTimeBetween('-90 days', '+5 days'),
        ];
    }
}
