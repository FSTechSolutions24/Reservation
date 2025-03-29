<?php

use Illuminate\Support\Facades\Route;
use Modules\House\Http\Controllers\HouseController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('house', HouseController::class)->names('house');
});
