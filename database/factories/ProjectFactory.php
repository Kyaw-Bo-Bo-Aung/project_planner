<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word() , 
            'department' => fake()->word(), 
            'start_date' => fake()->dateTimeBetween('-2 week', '-1 week'), 
            'end_date' => fake()->dateTimeBetween('+1 week', '+2 week'), 
            'status' => rand(1,3)
        ];
    }
}
