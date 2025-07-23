<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Episode;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReviewSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function testReviewCreate()
    {
        $episode = Episode::factory()->create();
        $user    = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/reviews', [
            'episode_id' => $episode->id,
            'user_id'    => $user->id,
            'comment'    => 'Great episode!'
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'message',
                'review' => ['episode_id', 'user_id', 'comment', 'sentiment_score']
            ]);

        $this->assertDatabaseHas('reviews', [
            'episode_id' => $episode->id,
            'user_id'    => $user->id,
            'comment'    => 'Great episode!'
        ]);
    }

    public function testValidationFailsWithEmptyText()
    {
        $episode = Episode::factory()->create();
        $user    = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/reviews', [
            'episode_id' => $episode->id,
            'user_id'    => $user->id,
            'text'       => ''
        ]);

        $response->assertStatus(422);
    }
}
