<?php

use App\Http\Controllers\BooksController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\LoginRegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::controller(BooksController::class)->group(function(){
    Route::get('/books', 'index')->name('books.index');
    Route::get('/books/create', 'create')->name('books.create');
    Route::post('/books', 'store')->name('books.store');
    Route::delete('/books/{id}', 'destroy')->name('books.destroy');
    Route::get('/books/{id}', 'edit')->name('books.edit');
    Route::put('/books/{id}', 'update')->name('books.update');
    Route::post('/books/{id}', 'update')->name('books.update');
    Route::get('/books/detail/{id}', 'showCover')->name('books.detail');
});

Route::controller(LoginRegisterController::class)->group(function() {
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('regis.store');
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::post('/logout', 'logout')->name('logout');
});

Route::resource('gallery', GalleryController::class);

Route::get('/gallery/create', [GalleryController::class, 'create'])->name('gallery.create');

