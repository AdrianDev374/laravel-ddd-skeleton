<?php

use Laravel\Sanctum\Sanctum;

return [

    'stateful' => explode(
        ',',
        env(
            'SANCTUM_STATEFUL_DOMAINS',
            sprintf(
                '%s%s',
                'localhost,localhost:3000,127.0.0.1,127.0.0.1:8000,::1',
                Sanctum::currentApplicationUrlWithPort()
            )
        )
    ),

    'guard' => ['web'],

    'expiration' => null,

    'middleware' => [
        'verify_csrf_token' => \Company\Apps\Shared\Middlewares\VerifyCsrfToken::class,
        'encrypt_cookies' => \Company\Apps\Shared\Middlewares\EncryptCookies::class,
    ]
];
