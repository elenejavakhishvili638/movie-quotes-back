<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\GoogleRegistrationController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\Register\RegistrationController;
use App\Http\Controllers\Session\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerificationController;
use App\Models\Genre;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [RegistrationController::class, 'store'])->middleware('guest')->name('register.store');

Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login')->middleware('guest')->name('login.store');
    Route::post('/logout', 'logout')->middleware('auth:sanctum')->name('login.destroy');
});

Route::controller(VerificationController::class)->group(function () {
    Route::get('/email/verify/{id}/{hash}', 'verify')->middleware('signed')->name('verification.verify');
    Route::get('/email-change/verify/{id}/{hash}/{token}', 'verifyNewEmail')->middleware('signed')->name('email-change.verify');
    Route::post('/email/resend', 'resend')->name('email.resend');
});

Route::middleware('web')->group(function () {
    Route::controller(GoogleRegistrationController::class)->group(function () {
        Route::get('/auth/redirect', 'redirect')->name('auth.redirect');
        Route::get('/auth/google/callback', 'callback')->name('auth.google.callback');
    });
});

Route::middleware('guest')->group(function () {
    Route::controller(PasswordResetController::class)->group(function () {
        Route::post('/forgot-password', 'storeEmail')->name('password.email');
        Route::post('/reset-password', 'update')->name('password.update');
    });
});

Route::middleware('auth:sanctum')->group(function () {

    Route::controller(UserController::class)->group(function () {
        Route::get('/user', 'index')->name('user.show');
        Route::patch('/user/{id}', 'update')->name('user.update');
    });
    
    Route::controller(MovieController::class)->group(function () {
        Route::get('/movies', 'index')->name('movie.index');
        Route::get('/movie/{movie}', 'show')->name('movie.show');
        Route::post('/movie', 'store')->name('movie.store');
        Route::delete('/movie/{id}', 'destroy')->name('movie.destroy');
        Route::patch('/movie/{id}', 'update')->name('movie.update');
    });

    Route::get('/genres', [GenreController::class, 'index'])->name('genres.show');

    Route::controller(QuoteController::class)->group(function () {
        Route::get('/quotes', 'index')->name('quote.index');
        Route::post('/quote', 'store')->name('quote.store');
        Route::get('/quote/{quote}', 'show')->name('quote.show');
        Route::delete('/quote/{quote}', 'destroy')->name('quote.destroy');
        Route::patch('/quote/{id}', 'update')->name('quote.update');
    });

    Route::post('/quotes/{quote}/comments', [CommentController::class, 'store'])->name('comment.store');

    Route::controller(LikeController::class)->group(function () {
        Route::post('/quotes/{quote}/likes', 'store')->name('like.store');
        Route::delete('/quotes/{quote}/likes', 'destroy')->name('like.destroy');
    });

    Route::controller(NotificationController::class)->group(function () {
        Route::get('/notifications','index')->name('notification.index');
        Route::post('/notification/{id}','store')->name('notification.store');
        Route::post('/notifications/read-all','markAllAsRead')->name('notifications.markAllAsRead');
        Route::post('/notification/{id}/read','markAsRead')->name('notification.markAsRead');
    });
});