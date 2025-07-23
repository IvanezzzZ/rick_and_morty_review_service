<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use OpenApi\Attributes as OA;

#[OA\Schema(
    required: [
        'name',
        'email',
        'password'
    ],
    properties: [
        new OA\Property(
            property: 'name',
            description: 'user name',
            type: 'string',
            example: 'John'
        ),
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
        new OA\Property(
            property: 'password_confirmation',
            description: 'user password confirmation',
            type: 'string',
            example: 'password'
        ),
    ]
)]
class RegistrationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email'      => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users')],
            'password'   => ['required', 'string', 'confirmed', 'min:8', 'max:255'],
            'name'       => ['string', 'max:32']
        ];

    }
}
