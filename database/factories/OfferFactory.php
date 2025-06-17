<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OfferFactory extends Factory
{
    public function definition()
    {
        return [
            'title' => fake()->sentence(3),
            'target_url' => fake()->url(),
            'payout' => fake()->randomFloat(2, 0.1, 5.0),
            'user_id' => 1,
        ];
    }
}
