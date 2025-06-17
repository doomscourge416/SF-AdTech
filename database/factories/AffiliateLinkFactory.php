<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Support\Str as BaseStr;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AffiliateLink>
 */
class AffiliateLinkFactory extends Factory
{
    public function definition()
    {
return [
    'user_id' => fake()->numberBetween(1, 5),
    'offer_id' => fake()->numberBetween(1, 10),
    'token' => fake()->unique()->word(),
];
    }
}
