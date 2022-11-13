<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AutoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function () {

    Route::get('login', [AuthController::class, "login"]);
    Route::post('logout', [AuthController::class, "logout"]);
    Route::post('refresh', [AuthController::class, "refresh"]);
    Route::post('me', [AuthController::class, "me"]);

});

Route::group([
    'middleware' => 'api',
    'middleware' => 'auth',
    'prefix' => 'users'

], function () {
    Route::get('/', [UserController::class, "index"]);
    Route::post('/', [UserController::class, "create"]);
    Route::put('/', [UserController::class, "update"]);
    Route::delete('/{id}', [UserController::class, "delete"]);
});

Route::group([
    'middleware' => 'api',
    'middleware' => 'auth',
    'prefix' => 'autos'

], function () {
    Route::get('/', [AutoController::class, "index"]);
    Route::post('/', [AutoController::class, "create"]);
    Route::put('/', [AutoController::class, "update"]);
    Route::delete('/{id}', [AutoController::class, "delete"]);
});

Route::group([
    'middleware' => 'api',
    'middleware' => 'auth',
    'middleware' => 'admin',
    'prefix' => 'admin'

], function () {
    Route::get('/', [AdminController::class, "index"]);
    Route::post('/create-users', [AdminController::class, "createUser"]);
    Route::post('/create-autos', [AdminController::class, "createAuto"]);
    Route::put('/update-user', [AdminController::class, "updateUser"]);
    Route::put('/update-auto', [AdminController::class, "updateAuto"]);
    Route::delete('/delete-user/{id}', [AdminController::class, "delete"]);
});

