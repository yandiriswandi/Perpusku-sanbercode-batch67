<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShelfController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\CategoryController;

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('index');
    })->name('dashboard');
    Route::resource('category', CategoryController::class);
    Route::resource('shelf', ShelfController::class);
    Route::resource('book', BookController::class);
    Route::resource('user', UserController::class)->middleware(IsAdmin::class);
    Route::resource('loan', LoanController::class);
    Route::resource('profile', ProfileController::class);
    Route::patch('/loan/{loan}/status', [LoanController::class, 'updateStatus'])->name('loan.updateStatus');
    Route::post('/comments/{book_id}',[CommentsController::class,'comments'])->name('comment.store');
    Route::put('/comments/{comment_id}',[CommentsController::class,'update'])->name('comment.update');

});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.auth');
Route::get('/check', [AuthController::class, 'getProfile'])->name('profile.redirect')->middleware('auth');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


