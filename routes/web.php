<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\LibraryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/book', [BookController::class, 'index'])->name('book.index');
Route::get('/book/create', [BookController::class, 'create'])->name('book.create');
Route::get('/book/{id}/edit', [BookController::class, 'edit'])->name('book.edit');

Route::put('/book/{id}', [BookController::class, 'update'])->name('book.update');
Route::delete('/book/{id}', [BookController::class, 'destroy'])->name('book.destroy');
Route::get('/book/{id}', [BookController::class, 'show'])->name('book.show');
Route::post('/book', [BookController::class, 'store'])->name('book.store');

Route::get('/library', [LibraryController::class, 'index'])->name('library.index');
Route::get('/library/create', [LibraryController::class, 'create'])->name('library.create');
Route::get('/library/{id}/edit', [LibraryController::class, 'edit'])->name('library.edit');

Route::put('/library/{id}', [LibraryController::class, 'update'])->name('library.update');
Route::delete('/library/{id}', [LibraryController::class, 'destroy'])->name('library.destroy');
Route::get('/library/{id}', [LibraryController::class, 'show'])->name('library.show');
Route::post('/library', [LibraryController::class, 'store'])->name('library.store');
