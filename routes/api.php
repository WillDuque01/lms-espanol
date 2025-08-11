<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\VideoProgressController;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/video/progress', [VideoProgressController::class, 'store']);
});


