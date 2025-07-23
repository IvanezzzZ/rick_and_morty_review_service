<?php

declare(strict_types=1);

namespace Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserAuthTest extends TestCase
{
    use RefreshDatabase;

    public function testAuthUser()
    {
        User::query()->create([
            'name'     => 'John Doe',
            'email'    => 'john@mail.ru',
            'password' => Hash::make('password')
        ]);

        $payload = [
            'email'    => 'john@mail.ru',
            'password' => 'password',
        ];

        $response = $this->postJson('/api/users/login', $payload);

        $response->assertStatus(200)
            ->assertJsonStructure(['token']);
    }

    public function testAuthUserWithInvalidPassword()
    {
        User::query()->create([
            'name'     => 'John Doe',
            'email'    => 'john@mail.ru',
            'password' => Hash::make('password')
        ]);

        $payload = [
            'email'    => 'john@mail.ru',
            'password' => 'password123',
        ];

        $response = $this->postJson('/api/users/login', $payload);

        $response->assertStatus(401)
            ->assertJsonStructure(['error']);
    }
}
