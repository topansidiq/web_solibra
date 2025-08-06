<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    NotificationController,
    OTPController,
    GuestController,
    RegisterController,
    LoginController,
    BookController,
    BorrowController,
    CategoryController,
    CollectionController,
    DashboardController,
    EventController,
    MemberController,
    UserController,
    WebhookController,
    WhatsAppController
};
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

// WhatsApp Route
Route::post('/api/wa/response', [WebhookController::class, 'handleAction']);
Route::get('/api/wa/user-exists', [WhatsAppController::class, 'checkUserExists']);

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function () {
    Route::get('/', [GuestController::class, 'home'])->name('home');
    Route::get('/collection', [GuestController::class, 'collection'])->name('collection');
    Route::get('/profile', [GuestController::class, 'profile'])->name('profile');
    Route::get('/event', [GuestController::class, 'event'])->name('event');
    Route::get('/information', [GuestController::class, 'information'])->name('information');

    // Show
    Route::get('/show/book/{book}', [GuestController::class, 'showBook'])->name('show.book');
    Route::get('/show/event/{event}', [GuestController::class, 'showEvent'])->name('show.event');

    // Auth Routes
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    // Member/User Routes
    Route::middleware(['auth', 'role:member'])->group(function () {
        Route::get('/member/dashboard', [MemberController::class, 'dashboard'])->name('member.index');

        Route::get('/member/collection', [MemberController::class, 'collection'])->name('member.collection');
        Route::get('/member/profile', [MemberController::class, 'profile'])->name('member.profile');
        Route::get('/member/notification', [MemberController::class, 'notification'])->name('member.notification');
        Route::get('/member/account', [MemberController::class, 'account'])->name('member.account');

        // Borrow Menu
        Route::get('/member/borrow', [MemberController::class, 'borrow'])->name('member.borrow');
        // Route::patch('/borrows/{borrow}', [BorrowController::class, 'showBorrowForm'])->name('member.borrow');

        // Phone Number Verification
        Route::get('/member/verification', [MemberController::class, 'phoneNumberVerification'])->name('member.verification');
    });
});

// Admin or Librarian Routes
Route::middleware(['auth', 'role:admin,librarian'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Resource routes
    // Route::resource('books', BookController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('borrows', BorrowController::class);
    Route::resource('users', UserController::class);
    Route::resource('events', EventController::class);

    // Custom book routes
    Route::get('/admin/books', [BookController::class, 'index'])->name('books.index');
    Route::get('/admin/books/create', [BookController::class, 'create'])->name('books.create');
    Route::get('/admin/books/edit', [BookController::class, 'edit'])->name('books.edit');
    Route::post('/admin/books', [BookController::class, 'store'])->name('books.store');
    Route::put('/books/{book}', [BookController::class, 'update'])->name('books.update');
    Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');
    Route::get('/books/search', [BookController::class, 'search'])->name('books.search');

    // Custom borrow actions
    Route::patch('/borrows/{borrow}/confirm', [BorrowController::class, 'confirm'])->name('borrows.confirm');
    Route::patch('/borrows/{borrow}/return', [BorrowController::class, 'return'])->name('borrows.return');
    Route::patch('/borrows/{borrow}/overdue', [BorrowController::class, 'overdue'])->name('borrows.overdue');
    Route::post('/borrows/{borrow}/extend', [BorrowController::class, 'extend'])->name('borrows.extend');
    Route::patch('/borrows/{borrow}/archive', [BorrowController::class, 'archive'])->name('borrows.archive');
});

// All User Route
Route::middleware(['auth', 'role:admin,librarian,member'])->group(function () {

    // Notification
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');

    // Borrow
    Route::patch('/users/{user}/verified-phone-number', [UserController::class, 'verifiedPhoneNumber'])->name('users.verified-phone-number');

    // WhatsApp Bot
    Route::post('/otp/send', [OTPController::class, 'sendOtp'])->name('otp.send');
    Route::post('/otp/verify', [OTPController::class, 'verifyOtp'])->name('otp.verify');
});
