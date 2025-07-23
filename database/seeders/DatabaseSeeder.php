<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
         User::factory(5)->create();
         Review::factory(20)->create();
    }
}
