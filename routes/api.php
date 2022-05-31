<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('user/all', [Controllers\UserController::class, 'all']);
Route::get('user/{id}', [Controllers\UserController::class, 'getById']);
Route::get('user/{id}/profile', [Controllers\UserController::class, 'profile']);
Route::post('user/create', [Controllers\UserController::class, 'create']);
Route::put('user/{id}/update', [Controllers\UserController::class, 'update']);
Route::delete('user/{id}/delete', [Controllers\UserController::class, 'destroy']);

