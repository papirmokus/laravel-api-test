<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('users', [UserController::class, 'index']);
Route::get('users-by-email', [UserController::class, 'getUserByEmail']);
Route::get('users-count', [UserController::class, 'getUserCount']);
Route::post('users', [UserController::class, 'createUser']);
Route::delete('users-remove-by-email', [UserController::class, 'removeUser']);
Route::patch('users', [UserController::class, 'updateUser']);
