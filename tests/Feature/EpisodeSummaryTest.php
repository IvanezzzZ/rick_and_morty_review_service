<?php

declare(strict_types=1);

namespace Feature;

use App\Models\Episode;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EpisodeSummaryTest extends TestCase
{
    use RefreshDatabase;

    public function testSummaryReturnsCorrectData()
    {
        $episode = Episode::factory()->create();
        $user    = User::factory()->create();

        Review::factory(5)->create();

        $response = $this->actingAs($user)->getJson("/api/episodes/{$episode->id}/summary");

        $response->assertOk()
            ->assertJsonStructure([
                'name',
                'air_date',
                'average_sentiment_score',
                'last_3_reviews' => [['comment', 'sentiment_score']]
            ]);
    }
}
