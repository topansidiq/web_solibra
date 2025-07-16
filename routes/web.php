<?php

use App\Http\Controllers\GuestController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\UserController;

// Guest
Route::get('/', [GuestController::class, 'home'])->name('home');
Route::get('/collection', [GuestController::class, 'collection'])->name('collection');
Route::get('/profile', [GuestController::class, 'profile'])->name('profile');

// Show
Route::get('/show/book/{book}', [GuestController::class, 'showBook'])->name('show.book');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// 🔒 Member/User Routes
Route::middleware(['auth', 'role:member'])->group(function () {
    Route::get('/member/dashboard', [MemberController::class, 'dashboard'])->name('member.index');

    Route::get('/member/collection', [MemberController::class, 'collection'])->name('member.collection');
    Route::get('/member/profile', [MemberController::class, 'profile'])->name('member.profile');

    Route::patch('/users/{user}/verified-phone-number', [UserController::class, 'verifiedPhoneNumber'])->name('users.verified-phone-number');

    // Borrow Menu
    Route::get('/member/borrow', [MemberController::class, 'borrow'])->name('member.borrow');
    // Route::patch('/borrows/{borrow}', [BorrowController::class, 'showBorrowForm'])->name('member.borrow');
});

// 🔒 Admin or Librarian Routes
Route::middleware(['auth', 'role:admin,librarian'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Resource routes
    Route::resource('books', BookController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('borrows', BorrowController::class);
    Route::resource('users', UserController::class);

    // Custom Book routes
    Route::put('/books/{book}', [BookController::class, 'update'])->name('books.update');
    Route::get('/books/search', [BookController::class, 'search'])->name('books.search');

    // Borrow custom actions
    Route::patch('/borrows/{borrow}/confirm', [BorrowController::class, 'confirm'])->name('borrows.confirm');
    Route::patch('/borrows/{borrow}/return', [BorrowController::class, 'return'])->name('borrows.return');
    Route::patch('/borrows/{borrow}/overdue', [BorrowController::class, 'overdue'])->name('borrows.overdue');
    Route::patch('/borrows/{borrow}/archive', [BorrowController::class, 'archive'])->name('borrows.archive');
});
