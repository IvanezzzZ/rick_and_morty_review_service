<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\EpisodeResource;
use App\Models\Episode;
use OpenApi\Attributes as OA;

class EpisodeController extends Controller
{
    #[OA\Get(
        path: '/api/episodes/{episode}/summary',
        description: 'Return summary about the episode',
        security: [['bearerAuth' => []]],
        tags: ['Episode'],
        parameters: [
            new OA\Parameter(
                name: 'episode',
                description: 'Id of the episode.',
                in: 'path',
                schema: new OA\Schema(type: 'integer'),
                example: 1
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Success',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(ref: EpisodeResource::class)
                )
            ),
            new OA\Response(
                response: 401,
                description: 'Unauthorized',
                content: new OA\JsonContent(
                    example: [
                        'error' => 'Unauthorized'
                    ]
                )
            ),
        ]
    )]
    public function summary(Episode $episode): EpisodeResource
    {
        $episode->load('reviews');

        return new EpisodeResource($episode);
    }
}
