<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ModuleController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::group(['middleware' => ['auth:api']], function () {

    Route::post('user/{user}/permissions', [UserController::class, 'assignPermissionsToUser'])->name('assignPermissionsToUser');
    Route::post('user/{user}/assign-role', [UserController::class, 'assignRoleToUser'])->name('assignRoleToUser');

    // we need to convert these routes to apiResource
    Route::post('user/createUser', [UserController::class, 'createUser'])->name('createUser');
    Route::patch('user/updateUser/{user}', [UserController::class, 'updateUser'])->name('updateUser');
    Route::delete('user/deleteUser/{user}', [UserController::class, 'deleteUser'])->name('deleteUser');
    Route::get('user/getUser/{user}', [UserController::class, 'getUser'])->name('getUser');

    Route::get('modules', [ModuleController::class, 'index']);
    Route::post('modules/uninstall/{moduleName}', [ModuleController::class, 'uninstall']);
    Route::post('modules/install/{moduleName}', [ModuleController::class, 'install']);
    Route::post('modules/migrate/{moduleName}', [ModuleController::class, 'migrate']);
    Route::post('modules/scan', [ModuleController::class, 'scanAndRegisterModules']);

    Route::apiResource('role', RoleController::class);
    Route::apiResource('city', CityController::class);
    Route::apiResource('area', AreaController::class);

});

