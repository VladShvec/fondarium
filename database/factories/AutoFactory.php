<?php

namespace Database\Factories;

use App\Models\Auto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Auto>
 */
class AutoFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Auto::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $autoMarks = ["Volkswagen", "Mercedes", "BMW", "Ford", "Hyundai", "Kia", "Mazda"];

        return [
            "auto_mark" => fake()->randomElement($autoMarks),
            "auto_number" => fake()->numberBetween(10000, 99999),
            "auto_color" => fake()->colorName,
            "user_id" => fake()->unique()->numberBetween(1, 10),
        ];
    }
}
