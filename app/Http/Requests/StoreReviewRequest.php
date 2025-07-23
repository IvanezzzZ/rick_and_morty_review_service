<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

#[OA\Schema(
    required: [
        'episode_id',
        'comment'
    ],
    properties: [
        new OA\Property(
            property: 'episode_id',
            description: 'episode ID',
            type: 'integer',
            example: '1'
        ),
        new OA\Property(
            property: 'comment',
            description: 'comment of the episode',
            type: 'string',
            example: 'This episode is very amazing'
        )
    ]
)]
class StoreReviewRequest extends FormRequest
{
    public function getComment(): string
    {
        return (string) $this->validated('comment');
    }

    public function getEpisodeId(): int
    {
        return (int) $this->validated('episode_id');
    }

    public function rules(): array
    {
        return [
            'episode_id' => ['required', 'integer', 'exists:episodes,id'],
            'comment'    => ['required', 'string', 'min:3'],
        ];
    }
}
