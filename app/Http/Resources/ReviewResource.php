<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'episode_id'      => $this->episode_id,
            'user_id'         => $this->user_id,
            'comment'         => $this->comment,
            "sentiment_score" => $this->sentiment_score
        ];
    }
}
