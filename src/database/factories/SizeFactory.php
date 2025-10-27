<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SizeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'sizeCode' => $this->faker->unique()->lexify('??'),
            'sizeName' => $this->faker->word,
            'sizeGroup' => $this->faker->randomElement(['Standard', 'European', 'Asian']),
            'sizeStatus' => $this->faker->boolean,
        ];
    }
}
