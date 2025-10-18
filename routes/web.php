<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Middleware\CheckSubscriptionAccess;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers;

// Route::get('/', function () {
//     return view('welcome');
// });

// Главная страница
Route::get('/', [BaseController::class, 'index'])->name('home');

// Маршруты для книг
Route::get('/books', [BaseController::class, 'index'])->name('books.index');
Route::get('/books/{book}', [BaseController::class, 'show'])->name('books.show');

// Защищенные маршруты (требуют подписку)
Route::middleware(['auth', CheckSubscriptionAccess::class])->group(function () {
    Route::get('/books/{book}/read', [BaseController::class, 'read'])->name('books.read');
    Route::get('/books/{book}/download', [BaseController::class, 'download'])->name('books.download');
    Route::get('/books/{book}/audio', [BaseController::class, 'audio'])->name('books.audio');
    Route::get('/library', [BaseController::class, 'library'])->name('books.library');
    Route::get('/books/search', [BaseController::class, 'search'])->name('books.search');
});

// Подписки
Route::prefix('subscriptions')->group(function () {
    Route::get('/book/{book}/select', [SubscriptionController::class, 'select'])->name('subscriptions.book.select');
    Route::post('/book/{book}/subscribe', [SubscriptionController::class, 'subscribe'])->name('subscriptions.book.subscribe');
    Route::get('/book/{book}/success', [SubscriptionController::class, 'bookSuccess'])->name('subscriptions.book.success');
    Route::get('/', [SubscriptionController::class, 'index'])->name('subscriptions.index');
    Route::post('/subscribe', [SubscriptionController::class, 'subscribe'])->name('subscriptions.subscribe');
    Route::get('/success', [SubscriptionController::class, 'success'])->name('subscriptions.success');
    Route::get('/history', [SubscriptionController::class, 'history'])->name('subscriptions.history');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
