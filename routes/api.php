<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SuccessfulEmail\SuccessfulEmailResourceController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'auth',
], function () {
    Route::post('/login', [LoginController::class, 'index']);
});

Route::group([
    'prefix' => 'successful-emails',
    'middleware' => ['client'],
], function () {
    Route::get('/', [SuccessfulEmailResourceController::class, 'index']);
    Route::get('/{id}', [SuccessfulEmailResourceController::class, 'show']);
    Route::post('/create', [SuccessfulEmailResourceController::class, 'store']);
    Route::patch('/update', [SuccessfulEmailResourceController::class, 'update']);
    Route::delete('/{id}', [SuccessfulEmailResourceController::class, 'delete']);
});
