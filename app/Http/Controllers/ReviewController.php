<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use App\Services\SentimentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OA;

class ReviewController extends Controller
{
    public function __construct(
        private readonly SentimentService $service,
    ){}

    #[OA\Post(
        path: '/api/reviews',
        description: 'Create a review about the episode',
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(ref: StoreReviewRequest::class)
        ),
        tags: ['Review'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Success',
                content: new OA\JsonContent(
                    example: [
                        'message' => 'Review created successfully',
                        'reviews' => [
                            'episode_id'      => 1,
                            'user_id'         => 1,
                            'comment'         => 'This episode is very amazing',
                            'sentiment_score' => 0.81
                        ]
                    ]
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
            new OA\Response(
                response: 422,
                description: 'Invalid request body',
                content: new OA\JsonContent(
                    example: [
                        'message' => 'The comment field must be at least 3 characters',
                        'errors'  => [
                            'comment' => ['The comment field must be at least 3 characters'],
                        ]
                    ]
                )
            ),
        ]
    )]
    public function store(StoreReviewRequest $request): JsonResponse
    {
        $score = $this->service->score($request->getComment());

        $review = Review::query()->create([
            'episode_id'      => $request->getEpisodeId(),
            'user_id'         => Auth::user()->id,
            'comment'         => $request->getComment(),
            'sentiment_score' => $score,
        ]);

        return response()->json([
            'message' => 'Review created successfully',
            'review'  => new ReviewResource($review),
        ], 201);
    }
}
