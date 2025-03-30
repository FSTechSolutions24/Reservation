<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ModuleController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::group(['middleware' => ['auth:api']], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('modules', [ModuleController::class, 'index']);
    Route::post('modules/uninstall/{moduleName}', [ModuleController::class, 'uninstall']);
    Route::post('modules/install/{moduleName}', [ModuleController::class, 'install']);
    Route::post('modules/migrate/{moduleName}', [ModuleController::class, 'migrate']);
    Route::post('modules/scan', [ModuleController::class, 'scanAndRegisterModules']);

    Route::apiResource('city', CityController::class);
    Route::apiResource('area', AreaController::class);

});

