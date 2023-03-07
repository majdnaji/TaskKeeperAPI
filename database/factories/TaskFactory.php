<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
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
            "title"=>$this->faker->sentence(),
            "deadline"=>$this->faker->dateTime(),
            "status"=>$this->faker->randomElement(["todo","in_progress","done"]),
            "department_id"=>$this->faker->randomElement([1,2,3])
        ];
    }
}
