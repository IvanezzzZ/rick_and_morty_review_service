<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use OpenApi\Attributes as OA;

class AuthController extends Controller
{
    #[OA\Post(
        path: '/api/users/registration',
        description: 'Add user to DB, return user info and token',
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(ref: RegistrationRequest::class)
        ),
        tags: ['Auth'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'User successfully registered',
                content: new OA\JsonContent(
                    example: [
                        'token' => '5|tKw4YUa25GKmqOQzD4strNo6Avl3k9b18xcRKx7b5bcff9e9',
                        'user'  => [
                            'name' => 'John',
                            'email' => 'john@mail.ru',
                        ]
                    ]
                )
            ),
            new OA\Response(
                response: 422,
                description: 'Invalid request body',
                content: new OA\JsonContent(
                    example: [
                        'message' => 'The password field must be at least 8 characters',
                        'errors' => [
                            'password' => ['The password field must be at least 8 characters'],
                        ]
                    ]
                )
            ),
        ]
    )]
    public function registration(RegistrationRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        $user = User::query()->create($data);

        return response()->json([
            'token' => $user->createToken('auth_user_token')->plainTextToken,
            'user'  => new UserResource($user),
        ], 201);
    }

    #[OA\Post(
        path: '/api/users/login',
        description: 'Create and return user token',
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(ref: LoginRequest::class)
        ),
        tags: ['Auth'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'User logged in successfully and token generated',
                content: new OA\JsonContent(
                    example: ['token' => '5|tKw4YUa25GKmqOQzD4strNo6Avl3k9b18xcRKx7b5bcff9e9']
                )
            ),
            new OA\Response(
                response: 401,
                description: 'Unauthorized',
                content: new OA\JsonContent(
                    example: ['error' => 'Unauthorized']
                )
            ),
        ]
    )]
    public function createToken(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        if (! Auth::attempt($credentials)) {
            return response()->json([
                'error' => 'Unauthorized'
            ], 401);
        }

        $token = Auth::user()->createToken('auth_user_token');

        return response()->json([
            'token' => $token->plainTextToken
        ]);
    }
}
