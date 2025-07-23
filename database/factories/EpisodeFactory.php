<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EpisodeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'external_id' => $this->faker->numberBetween(1, 10),
            'name'        => $this->faker->word,
            'air_date'    => $this->faker->date('Y-m-d'),
        ];
    }
}
