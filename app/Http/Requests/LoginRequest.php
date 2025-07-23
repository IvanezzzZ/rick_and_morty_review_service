<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

#[OA\Schema(
    required: [
        'email',
        'password'
    ],
    properties: [
        new OA\Property(
            property: 'email',
            description: 'user email',
            type: 'string',
            example: 'john@mail.ru'
        ),
        new OA\Property(
            property: 'password',
            description: 'user password',
            type: 'string',
            example: 'password'
        ),
    ]
)]
class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email'    => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }
}
