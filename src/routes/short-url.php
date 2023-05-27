<?php

use Tleckie\Url\Infrastructure\Http\Controllers\ShortUrlController;
use Tleckie\Url\Infrastructure\Http\Middleware\TokenValidatorMiddleware;


Route::prefix('/v1')->group(function () {

    Route::post('/short-urls', [ShortUrlController::class, 'index'])
        ->middleware(TokenValidatorMiddleware::class);

});
