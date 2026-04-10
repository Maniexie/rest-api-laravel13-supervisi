<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// untuk membuat controller api
// php artisan make:controller UserController --api

Route::apiResource('users', UserController::class);
Route::patch('/users/{id}', [UserController::class, 'update']);
