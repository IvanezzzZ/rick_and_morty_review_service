<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use OpenApi\Attributes\Info;
use OpenApi\Attributes as OA;

#[Info(
    version: '1.0.0',
    description: 'Rick and Morty reviews API',
    title: 'API'
)]

#[OA\SecurityScheme(
    securityScheme: 'bearerAuth',
    type: 'http',
    name: 'Authorization',
    in: 'header',
    scheme: 'bearer'
)]
abstract class Controller
{
    //
}
