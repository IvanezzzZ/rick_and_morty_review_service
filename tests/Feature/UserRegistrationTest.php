<?php

declare(strict_types=1);

namespace Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function testRegistrationUser()
    {
        $payload = [
            'name'                  => 'John',
            'email'                 => 'john@mail.ru',
            'password'              => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->postJson('/api/users/registration', $payload);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'token',
                'user' => ['name', 'email']
            ]);

        $this->assertDatabaseHas('users', [
            'name'  => 'John',
            'email' => 'john@mail.ru',
        ]);
    }

    public function testRegistrationUserWithTooShortPassword()
    {
        $payload = [
            'name'                  => 'John',
            'email'                 => 'john@mail.ru',
            'password'              => 'pass',
            'password_confirmation' => 'pass',
        ];

        $response = $this->postJson('/api/users/registration', $payload);

        $response->assertStatus(422);
    }

    public function testRegistrationUserWithoutPasswordConfirmation()
    {
        $payload = [
            'name'     => 'John',
            'email'    => 'john@mail.ru',
            'password' => 'password',
        ];

        $response = $this->postJson('/api/users/registration', $payload);

        $response->assertStatus(422);
    }
}
