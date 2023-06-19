<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\GoogleRegistrationController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\Register\RegistrationController;
use App\Http\Controllers\Session\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerificationController;
use App\Models\Genre;
use Illuminate\Http\Request;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/user', [UserController::class, 'index'])->middleware('auth:sanctum')->name('user.show');
Route::patch('/user/{id}', [UserController::class, 'update'])->name('user.store');


Route::post('/register', [RegistrationController::class, 'store'])->middleware('guest')->name('register.store');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest')->name('login.store');

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('login.destroy');


Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->middleware('signed')->name('verification.verify');

Route::get('/auth/redirect', [GoogleRegistrationController::class, 'redirect'])->middleware('web');
Route::get('/auth/google/callback', [GoogleRegistrationController::class, 'callback'])->middleware('web');

Route::post('/forgot-password', [PasswordResetController::class, 'storeEmail'])->middleware('guest')->name('password.email');
Route::post('/reset-password', [PasswordResetController::class, 'update'])->middleware('guest')->name('password.update');

Route::get('/movies', [MovieController::class, 'index'])->name('movie.show');
Route::get('/all-movies', [MovieController::class, 'all'])->name('movie.all');
Route::get('/movie/{id}', [MovieController::class, 'show']);
Route::post('/movie', [MovieController::class, 'store'])->name('movie.store');
Route::delete('/movie/{id}', [MovieController::class, 'destroy'])->name('movie.destroy');
Route::patch('/movie/{id}', [MovieController::class, 'update'])->name('movie.update');


Route::get('/genres', function () {
    $genres = Genre::all();
    return response()->json($genres);
});

Route::get('/quotes', [QuoteController::class, 'index'])->name('quote.show');
Route::get('/quote/{id}', [QuoteController::class, 'show']);
Route::post('/quote', [QuoteController::class, 'store'])->name('quote.store');
Route::delete('/quote/{id}', [QuoteController::class, 'destroy'])->name('quote.destroy');
Route::patch('/quote/{id}', [QuoteController::class, 'update'])->name('quote.update');

Route::post('/quotes/{id}/comments', [CommentController::class, 'store'])->name('comment.store');

Route::post('/quotes/{id}/likes', [LikeController::class, 'store'])->name('like.store');
Route::delete('/quotes/{id}/likes', [LikeController::class, 'destroy'])->name('like.destroy');
