<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Episode extends Model
{
    use HasFactory;

    protected $fillable = [
        'external_id',
        'name',
        'air_date'
    ];

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function averageSentimentScore(): float
    {
        return round($this->reviews()->avg('sentiment_score') ?? 0, 2);
    }

    public function lastReviews(int $count = 3): Collection
    {
        return $this->reviews()->latest()->take($count)->get(['comment', 'sentiment_score']);
    }
}
