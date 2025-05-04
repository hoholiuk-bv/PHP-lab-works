<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\ReturnBookController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
});

Route::middleware(['auth:api', 'role:admin'])->group(function () {
    Route::resource('books', BookController::class);
});

Route::middleware(['auth:api', 'role:manager'])->group(function () {
    Route::resource('authors', AuthorController::class);
});

Route::middleware(['auth:api', 'role:client'])->group(function () {
    Route::get('profile', [ReturnBookController::class, 'edit']);
});

Route::middleware(['auth:api', 'role:client'])->group(function () {
    Route::get('profile', [ProfileController::class, 'edit']);
});

Route::middleware(['auth:api', 'role:client'])->group(function () {
    Route::get('profile', [ProfileController::class, 'edit']);
});
