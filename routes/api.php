<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::post('/posts', [PostController::class, 'create']);
//Route::get('/posts', [PostController::class, 'all']);
Route::get('/posts/{id}', [PostController::class, 'find']);
//Route::put('/posts/{id}', [PostController::class, 'update']);
//Route::delete('/posts/{id}', [PostController::class, 'delete']);
