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
        Route::post('/books/{book}/store', 'store')->name('store');
        Route::delete('/books/{book}/remove', 'destroy')->name('destroy');
    });
});

// Ресурсные маршруты
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');

Route::get('/authors', [AuthorController::class, 'index'])->name('authors.index');
Route::get('/authors/{author}', [AuthorController::class, 'show'])->name('authors.show');

// Защищённые маршруты (только для админов)
Route::middleware(['is_auth', 'is_admin'])->group(function () {

    Route::get('/create-category', [CategoryController::class, 'create'])->name('categories.create');
    Route::get('/create-book', [BookController::class, 'create'])->name('books.create');
    Route::get('/create-author', [AuthorController::class, 'create'])->name('authors.create');

    Route::resource('categories', CategoryController::class)->except(['index', 'create', 'show']);
    Route::resource('books', BookController::class)->except(['index', 'create', 'show']);
    Route::resource('authors', AuthorController::class)->except(['index', 'create', 'show']);
});

// Резервный маршрут
Route::fallback(function () {
    return redirect()->route('index')->with('error', 'Возникла непредвиденная ошибка');
});
