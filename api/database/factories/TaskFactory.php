<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lecture>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(2,true),
            'description' => $this->faker->sentence(10,true),
            'points' => $this->faker->numberBetween(1,101),
            'deadline' => $this->faker->dateTime(),
        ];
    }
}
