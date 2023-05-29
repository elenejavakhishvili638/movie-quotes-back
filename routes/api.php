<?php

use App\Http\Controllers\Register\RegistrationController;
use App\Http\Controllers\Session\AuthController;
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

Route::post('/register', [RegistrationController::class, 'store'])->middleware('guest')->name('register.store');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest')->name('login.store');
