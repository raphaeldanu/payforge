<?php

use App\Http\Controllers\Api\V1\CurrencyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/currencies', [CurrencyController::class, 'index']);

    Route::get('/currencies/{code}', [CurrencyController::class, 'show']);
});
