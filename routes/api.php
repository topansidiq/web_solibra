<?php

use App\Http\Controllers\MemberController;
use App\Http\Controllers\OTPController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => "puks",
    'middleware' => ['api.key']
], function () {
    Route::get('/getUserByPhone', [MemberController::class, 'getUserByPhone']);
    Route::post('/otp/get', [OTPController::class, 'get'])->name('otp.get');
    Route::get('/otp/verify', [OTPController::class, 'verify'])->name('otp.verify');
    Route::post('/otp/verify', [OTPController::class, 'verifyOtp'])->name('otp.verify');
});
