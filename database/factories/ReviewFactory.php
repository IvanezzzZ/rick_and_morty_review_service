<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Episode;
use App\Models\User;
use App\Services\SentimentService;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    public function definition(): array
    {
        $comment = $this->faker->realText();

        return [
            'episode_id'      => Episode::query()->inRandomOrder()->first()->id,
            'user_id'         => User::query()->inRandomOrder()->first()->id,
            'comment'         => $comment,
            'sentiment_score' => app(SentimentService::class)->score($comment)
        ];
    }
}
