<?php

use App\Http\Controllers\FavoriteController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\{
    NotificationController,
    OTPController,
    GuestController,
    BookController,
    BorrowController,
    CategoryController,
    DashboardController,
    EventController,
    MemberController,
    UserController,
    InformationController
};
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function () {
    Route::get('/', [GuestController::class, 'home'])->name('home');
    Route::get('/collection', [GuestController::class, 'collection'])->name('collection');
    Route::get('/profile', [GuestController::class, 'profile'])->name('profile');
    Route::get('/service', [GuestController::class, 'service'])->name('service');
    Route::get('/event', [GuestController::class, 'event'])->name('event');
    Route::get('/information', [GuestController::class, 'information'])->name('information');

    // Show
    Route::get('/show/book/{book}', [GuestController::class, 'showBook'])->name('show.book');
    Route::get('/show/event/{event}', [GuestController::class, 'showEvent'])->name('show.event');
    Route::get('/show/information/{info}', [GuestController::class, 'showInformation'])->name('show.information');

    // Auth Routes
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/forgot-password', [PasswordController::class, 'showForgotPasswordForm'])->name('password.forgot');
    Route::post('/forgot-password', [PasswordController::class, 'sendResetPasswordLink'])->name('password.link');
    Route::get('/reset-password/{token}', [PasswordController::class, 'showResetPasswordForm'])->name('password.reset');



    // Member/User Routes
    Route::middleware(['auth', 'role:member'])->group(function () {
        Route::get('/member/dashboard', [MemberController::class, 'dashboard'])->name('member.index');

        Route::get('/member/account/edit', [MemberController::class, 'edit'])->name('member.account.edit');

        // Custom collectiom routes
        Route::get('/member/collection', [MemberController::class, 'collection'])->name('member.collection');
        Route::get('/member/collection/{book}', [MemberController::class, 'showCollection'])->name('member.collection.show');
        Route::get('/member/collection/{favorite}', [FavoriteController::class, 'toggleFavorite'])->name('member.collection.favorite');

        Route::get('/member/profile', [MemberController::class, 'profile'])->name('member.profile');
        Route::get('/member/service', [MemberController::class, 'service'])->name('member.service');
        Route::get('/member/information', [MemberController::class, 'information'])->name('member.information');
        Route::get('/member/information/{information}', [MemberController::class, 'show'])->name('member.information.show');
        Route::get('/member/notification', [MemberController::class, 'notification'])->name('member.notification');
        Route::get('/member/account', [MemberController::class, 'account'])->name('member.account');

        // Borrow Menu
        Route::get('/member/borrow', [MemberController::class, 'borrow'])->name('member.borrow');
        Route::post('/member/borrow', [MemberController::class, 'storeBorrow'])->name('member.borrow.store');
        Route::get('/member/borrow/search', [MemberController::class, 'searchBooks']);

        // Phone Number Verification
        Route::get('/member/verification', [MemberController::class, 'phoneNumberVerification'])->name('member.verification');
        Route::post('/member/verification', [OTPController::class, 'verify'])->name('member.verifing');
        Route::get('/member/verification/otp', [OTPController::class, 'verifyOtp'])->name('member.verification.otp');
    });
});

// Admin or Librarian Routes
Route::middleware(['auth', 'role:admin,librarian'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Resource routes
    Route::resource('books', BookController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('borrows', BorrowController::class);
    Route::resource('users', UserController::class);
    Route::resource('events', EventController::class);
    Route::resource('informations', InformationController::class);

    // Custom book routes
    Route::get('/books/search', [BookController::class, 'search'])->name('books.search');

    // Costum categories route
    Route::post('/categories/storeOnBook', [CategoryController::class, 'storeOnBook'])->name('categories.store-on-book');

    // Custom users routes
    Route::post('/users/validation', [UserController::class, 'userValidation'])->name('users.validation');

    // Custom borrow actions
    Route::patch('/borrows/{borrow}/confirm', [BorrowController::class, 'confirm'])->name('borrows.confirm');
    Route::patch('/borrows/{borrow}/return', [BorrowController::class, 'return'])->name('borrows.return');
    Route::patch('/borrows/{borrow}/overdue', [BorrowController::class, 'overdue'])->name('borrows.overdue');
    Route::post('/borrows/{borrow}/extend', [BorrowController::class, 'extend'])->name('borrows.extend');
    Route::patch('/borrows/{borrow}/archive', [BorrowController::class, 'archive'])->name('borrows.archive');

    // Custom return route
    Route::get('/admin/return', [BorrowController::class, 'returnTable'])->name('return.index');
    Route::get('/admin/return/{borrow}', [BorrowController::class, 'returnShow'])->name('return.show');

    //informations
    Route::put('/informations/{id}', [InformationController::class, 'update'])->name('informations.update');
    Route::get('/informations/{id}/edit', [InformationController::class, 'edit'])->name('informations.edit');
});

// All User Route
Route::middleware(['auth', 'role:admin,librarian,member'])->group(function () {
    // Users


    // Notification
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');

    // Borrow
    Route::patch('/users/{user}/verified-phone-number', [UserController::class, 'verifiedPhoneNumber'])->name('users.verified-phone-number');

    // OTP
    Route::resource('otps', OTPController::class);

    // WhatsApp Bot
});
