<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\ReaderController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\ReturnBookController;

Route::get('/', fn () => Inertia::render('welcome'))->name('home');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'registerWeb'])->name('register.submit');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'loginWeb'])->name('login.submit');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', fn () => Inertia::render('dashboard'))->name('dashboard');
});

Route::prefix('api')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware(['auth:api'])->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);

        Route::get('books', [BookController::class, 'index']);
        Route::get('books/{book}', [BookController::class, 'show']);
        Route::delete('books/{book}', [BookController::class, 'destroy'])->middleware('role:admin');
        Route::middleware('role:manager,admin')->group(function () {
            Route::post('books', [BookController::class, 'store']);
            Route::put('books/{book}', [BookController::class, 'update']);
            Route::patch('books/{book}', [BookController::class, 'update']);
        });

        Route::get('authors', [AuthorController::class, 'index']);
        Route::get('authors/{author}', [AuthorController::class, 'show']);
        Route::delete('authors/{author}', [AuthorController::class, 'destroy'])->middleware('role:admin');
        Route::middleware('role:manager,admin')->group(function () {
            Route::post('authors', [AuthorController::class, 'store']);
            Route::put('authors/{author}', [AuthorController::class, 'update']);
            Route::patch('authors/{author}', [AuthorController::class, 'update']);
        });

        Route::get('readers', [ReaderController::class, 'index']);
        Route::get('readers/{reader}', [ReaderController::class, 'show']);
        Route::delete('readers/{reader}', [ReaderController::class, 'destroy'])->middleware('role:admin');
        Route::middleware('role:manager,admin')->group(function () {
            Route::post('readers', [ReaderController::class, 'store']);
            Route::put('readers/{reader}', [ReaderController::class, 'update']);
            Route::patch('readers/{reader}', [ReaderController::class, 'update']);
        });

        Route::get('loans', [LoanController::class, 'index']);
        Route::get('loans/{loan}', [LoanController::class, 'show']);
        Route::delete('loans/{loan}', [LoanController::class, 'destroy'])->middleware('role:admin');
        Route::middleware('role:manager,admin')->group(function () {
            Route::post('loans', [LoanController::class, 'store']);
            Route::put('loans/{loan}', [LoanController::class, 'update']);
            Route::patch('loans/{loan}', [LoanController::class, 'update']);
        });

        Route::get('returns', [ReturnBookController::class, 'index']);
        Route::get('returns/{return}', [ReturnBookController::class, 'show']);
        Route::delete('returns/{return}', [ReturnBookController::class, 'destroy'])->middleware('role:admin');
        Route::middleware('role:manager,admin')->group(function () {
            Route::post('returns', [ReturnBookController::class, 'store']);
            Route::put('returns/{return}', [ReturnBookController::class, 'update']);
            Route::patch('returns/{return}', [ReturnBookController::class, 'update']);
        });
    });
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
