<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AppUserController;
use App\Http\Controllers\Api\TaskController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::prefix('app/user')->group(function () {
    Route::post("auth/registration", [AppUserController::class, 'registerAppUser']);
    Route::post("auth/login", [AppUserController::class, 'loginAppUser']);
    Route::get("list", [AppUserController::class, 'getAppUsers']);
    Route::get("get", [AppUserController::class, 'getAppUser']);
    Route::get("auth/logout", [AppUserController::class, 'logoutAppUser']);
});

Route::prefix('task')->group(function () {
    Route::post("add", [TaskController::class, 'addTask']);
    Route::post("list", [TaskController::class, 'getTasks']);
    Route::get("{id}/detail", [TaskController::class, 'detailTask']);
    Route::post("{id}/update", [TaskController::class, 'updateTask']);
    Route::get("{id}/delete", [TaskController::class, 'deleteTask']);
});
