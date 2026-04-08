<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Author\AuthorController;
use App\Http\Controllers\Book\BookController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Profile\ProfileController;
use Illuminate\Support\Facades\Route;

// Главная страница
Route::get('/', HomeController::class)->name('index');

// Вход
Route::controller(LoginController::class)->prefix('/login')->name('login.')->group(function () {
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
});

// Регистрация
Route::controller(RegisterController::class)->prefix('/register')->name('register.')->group(function () {
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
});

// Защищенные маршруты
Route::middleware(['is_auth'])->group(function () {
    // Выход
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

    // Профиль
    Route::controller(ProfileController::class)->prefix('/profile')->name('profile.')->group(function () {
        Route::get('/', 'show')->name('show');
        Route::get('/edit', 'edit')->name('edit');
        Route::put('/update', 'update')->name('update');
        Route::put('/update-password', 'updatePassword')->name('update-password');
        Route::post('/books/{book}/add', 'addBookToLibrary')->name('add-book');
        Route::delete('/books/{book}/remove', 'removeBookFromLibrary')->name('remove-book');
    });
});

// Ресурсные маршруты
Route::resource('books', BookController::class);
Route::resource('authors', AuthorController::class);
Route::resource('categories', CategoryController::class);
