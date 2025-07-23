<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    properties: [
        new OA\Property(
            property: 'name',
            description: 'episode name',
            type: 'string',
            example: 'Pilot'),
        new OA\Property(
            property: 'air_date',
            description: 'release episode date',
            type: 'date',
            example: '2012-12-12'),
        new OA\Property(
            property: 'average_sentiment_score',
            description: 'average sentiment score episode',
            type: 'float',
            example: '0.66'),
        new OA\Property(
            property: 'last_3_reviews',
            description: 'last 3 review about episode',
            type: 'string',
            example: [
                [
                    'comment'         => 'This episode is very amazing',
                    'sentiment_score' => 0.8
                ],[
                    'comment'         => 'This episode is very good',
                    'sentiment_score' => 0.66
                ],[
                    'comment'         => 'This episode is bad',
                    'sentiment_score' => 0.1
                ],
            ]
        ),
    ]
)]
class EpisodeResource extends JsonResource
{
    public static $wrap = false;

    public function toArray(Request $request): array
    {
        return [
            'name'                    => $this->name,
            'air_date'                => $this->air_date,
            'average_sentiment_score' => $this->averageSentimentScore(),
            'last_3_reviews'          => $this->lastReviews()
        ];
    }
}
