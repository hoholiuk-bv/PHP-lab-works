<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\ReaderController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\ReturnBookController;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::resource('books', BookController::class);
Route::resource('authors', AuthorController::class);
Route::resource('readers', ReaderController::class);
Route::resource('loans', LoanController::class);
Route::resource('returns', ReturnBookController::class);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
