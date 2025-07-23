<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Episode;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class SyncEpisodes extends Command
{
    protected $signature = 'sync:episodes';
    protected $description = 'Загружает только новые эпизоды из Rick and Morty API';

    public function handle(): int
    {
        $this->info('Начинаем загрузку эпизодов...');

        $host     = config('services.rick_and_morty.host');
        $endpoint = config('services.rick_and_morty.endpoints.episodes');
        $url      = $host . $endpoint;

        $newEpisodes = collect();

        do {
            $response    = $this->fetchEpisodesPage($url);
            $apiEpisodes = collect($response['results']);

            $apiIds = $apiEpisodes->pluck('id');

            $existingIds = Episode::query()
                ->whereIn('external_id', $apiIds)
                ->pluck('external_id')
                ->all();

            $filtered = $apiEpisodes->reject(
                fn($episode) => in_array($episode['id'], $existingIds)
            );

            $mapped = $filtered->map(fn($episode) => [
                'external_id' => $episode['id'],
                'name'        => $episode['name'],
                'air_date'    => date('Y-m-d', strtotime($episode['air_date'])),
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);

            $newEpisodes = $newEpisodes->merge($mapped);

            $url = $response['info']['next'] ?? null;
        } while ($url);

        $this->insertNewEpisodes($newEpisodes);

        $this->info("Загружено новых эпизодов: {$newEpisodes->count()}");

        return self::SUCCESS;
    }

    private function fetchEpisodesPage(string $url): int|array
    {
        $response = Http::timeout(10)->get($url);

        if ($response->failed()) {
            $this->info("Ошибка запроса к Rick and Morty API: {$url}");

            return self::FAILURE;
        }

        return $response->json();
    }

    private function insertNewEpisodes(Collection $episodes): void
    {
        if ($episodes->isNotEmpty()) {
            Episode::query()->insert($episodes->all());
        }
    }
}

