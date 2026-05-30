<?php

use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\BorrowingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FineController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BookController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/books', [BookController::class, 'index'])->name('books.index');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

if (app()->environment('local')) {
    Route::get('/dev-admin-login', function () {
        $admin = User::where('role', 'admin')->orderBy('id')->first();

        if (! $admin) {
            abort(500, 'Admin user not found. Jalankan php artisan migrate:fresh --seed terlebih dahulu.');
        }

        auth()->login($admin);

        return redirect()->route('admin.dashboard');
    })->name('dev-admin-login');

    Route::get('/dev-admin-logout', function () {
        auth()->logout();

        return redirect('/');
    })->name('dev-admin-logout');
}

Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::post('users', [UserController::class, 'store'])->name('users.store');
    Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    Route::get('books', [AdminBookController::class, 'index'])->name('books.index');
    Route::post('books', [AdminBookController::class, 'store'])->name('books.store');
    Route::put('books/{book}', [AdminBookController::class, 'update'])->name('books.update');
    Route::delete('books/{book}', [AdminBookController::class, 'destroy'])->name('books.destroy');

    Route::get('borrowings', [BorrowingController::class, 'index'])->name('borrowings.index');
    Route::get('borrowings/create', [BorrowingController::class, 'create'])->name('borrowings.create');
    Route::post('borrowings', [BorrowingController::class, 'store'])->name('borrowings.store');
    Route::get('borrowings/history', [BorrowingController::class, 'history'])->name('borrowings.history');
    Route::post('borrowings/{borrowing}/approve', [BorrowingController::class, 'approve'])->name('borrowings.approve');
    Route::post('borrowings/{borrowing}/reject', [BorrowingController::class, 'reject'])->name('borrowings.reject');
    Route::post('borrowings/{borrowing}/return', [BorrowingController::class, 'returnBook'])->name('borrowings.return');

    Route::get('fines', [FineController::class, 'index'])->name('fines.index');
    Route::post('fines/{fine}/mark-paid', [FineController::class, 'markPaid'])->name('fines.mark-paid');

    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/pdf', [ReportController::class, 'downloadPdf'])->name('reports.pdf');
    Route::get('reports/excel', [ReportController::class, 'downloadExcel'])->name('reports.excel');
});
