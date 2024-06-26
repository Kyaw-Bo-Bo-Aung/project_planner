<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Timesheet>
 */
class TimesheetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'task_name' => fake()->firstName,
            'date' => fake()->date,
            'hours' => rand(1, 10),
            'user_id' => rand(1, 10),
            'project_id' => rand(1, 10),
        ];
    }
}
