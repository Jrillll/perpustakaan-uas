<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\AdminController;

// Guest Routes
Route::get('/', [BookController::class, 'landing'])->name('landing');
Route::get('/about', [BookController::class, 'about'])->name('about');

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated User Routes
Route::middleware(['auth'])->group(function () {
    
    Route::get('/dashboard', [BookController::class, 'index'])->name('dashboard');
    Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');
    Route::post('/books/{book}/review', [BookController::class, 'storeReview'])->name('books.review');
    
    Route::get('/books/{book}/borrow', [BorrowingController::class, 'showBorrowForm'])->name('books.borrow');
    Route::post('/books/{book}/borrow', [BorrowingController::class, 'borrow']);
    
    Route::get('/borrowings', [BorrowingController::class, 'index'])->name('borrowings.index');
    Route::post('/borrowings/{borrowing}/return', [BorrowingController::class, 'returnBook'])->name('borrowings.return');
    Route::get('/history', [BorrowingController::class, 'history'])->name('borrowings.history');
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Admin Specific Routes
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/borrowings/{borrowing}/approve', [AdminController::class, 'approve'])->name('admin.borrowings.approve');
    Route::post('/admin/borrowings/{borrowing}/reject', [AdminController::class, 'reject'])->name('admin.borrowings.reject');
});

