<?php

declare(strict_types=1);

namespace App\Services;

use Sentiment\Analyzer;

readonly class SentimentService
{
    public function __construct(
        private Analyzer $analyzer
    ) {}

    public function score(string $text): float
    {
        $result = $this->analyzer->getSentiment($text);

        $compound = $result['compound'];

        return round(($compound + 1) / 2, 2);
    }
}
