<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
           'name' => $this->faker->randomElement(['كراسي متحركة']),
           'description' => $this->faker->sentence(),
           'image' => $this->faker->imageUrl(300, 300, 'food'),
        
        ];
    }
}
