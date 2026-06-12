<?php

use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\BorrowingController as AdminBorrowingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FineController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowingController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])
    ->name('register');
Route::post('/register', [RegisterController::class, 'register'])
    ->name('register.post');

Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->name('login');
Route::post('/login', [LoginController::class, 'login'])
    ->name('login.post');

Route::view('/about', 'about')->name('about');

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [BookController::class, 'index'])
        ->name('dashboard');

    Route::get('/books', [BookController::class, 'index'])
        ->name('books.index');

    Route::get('/books/{book}', [BookController::class, 'show'])
        ->name('books.show');

    Route::post('/books/{book}/review', [BookController::class, 'review'])
        ->name('books.review');

    Route::get('/books/{book}/borrow', [BorrowingController::class, 'showBorrowForm'])
        ->name('books.borrow');

    Route::post('/books/{book}/borrow', [BorrowingController::class, 'borrow'])
        ->name('books.borrow.submit');
Route::get('/borrowings', [BorrowingController::class, 'index'])
    ->name('borrowings.index');

Route::get('/history', [BorrowingController::class, 'history'])
    ->name('borrowings.history');

Route::post('/borrowings/{borrowing}/return', [BorrowingController::class, 'returnBook'])
    ->name('borrowings.return');
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

        return redirect()->route('login');
    })->name('dev-admin-logout');
}

Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('users', [UserController::class, 'index'])
        ->name('users.index');
    Route::post('users', [UserController::class, 'store'])
        ->name('users.store');
    Route::put('users/{user}', [UserController::class, 'update'])
        ->name('users.update');
    Route::delete('users/{user}', [UserController::class, 'destroy'])
        ->name('users.destroy');

    Route::get('categories', [CategoryController::class, 'index'])
        ->name('categories.index');
    Route::post('categories', [CategoryController::class, 'store'])
        ->name('categories.store');
    Route::put('categories/{category}', [CategoryController::class, 'update'])
        ->name('categories.update');
    Route::delete('categories/{category}', [CategoryController::class, 'destroy'])
        ->name('categories.destroy');

    Route::get('books', [AdminBookController::class, 'index'])
        ->name('books.index');
    Route::post('books', [AdminBookController::class, 'store'])
        ->name('books.store');
    Route::put('books/{book}', [AdminBookController::class, 'update'])
        ->name('books.update');
    Route::delete('books/{book}', [AdminBookController::class, 'destroy'])
        ->name('books.destroy');

    Route::get('borrowings', [AdminBorrowingController::class, 'index'])
        ->name('borrowings.index');
    Route::get('borrowings/create', [AdminBorrowingController::class, 'create'])
        ->name('borrowings.create');
    Route::post('borrowings', [AdminBorrowingController::class, 'store'])
        ->name('borrowings.store');
    Route::get('borrowings/history', [AdminBorrowingController::class, 'history'])
        ->name('borrowings.history');
    Route::post('borrowings/{borrowing}/approve', [AdminBorrowingController::class, 'approve'])
        ->name('borrowings.approve');
    Route::post('borrowings/{borrowing}/reject', [AdminBorrowingController::class, 'reject'])
        ->name('borrowings.reject');
    Route::post('borrowings/{borrowing}/return', [AdminBorrowingController::class, 'returnBook'])
        ->name('borrowings.return');

    Route::get('fines', [FineController::class, 'index'])
        ->name('fines.index');
    Route::post('fines/{fine}/mark-paid', [FineController::class, 'markPaid'])
        ->name('fines.mark-paid');

    Route::get('reports', [ReportController::class, 'index'])
        ->name('reports.index');
    Route::get('reports/pdf', [ReportController::class, 'downloadPdf'])
        ->name('reports.pdf');
    Route::get('reports/excel', [ReportController::class, 'downloadExcel'])
        ->name('reports.excel');
});