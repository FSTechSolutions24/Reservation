<?php

use Illuminate\Support\Facades\Route;
use Modules\House\Http\Controllers\HouseController;

Route::middleware(['auth:api'])->group(function () {
    Route::apiResource('house', HouseController::class)->names('house');
});
