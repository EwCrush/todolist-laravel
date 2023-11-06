<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum'])->group(function () {
});

Route::post('/signin', [AuthController::class, 'handleSignin']);
Route::get('/signin', [AuthController::class, 'signin'])->name('signin');
Route::post('/signup', [AuthController::class, 'handleSignup']);
Route::get('/signup', [AuthController::class, 'signup'])->name('signup');
Route::get('/todo', [AuthController::class, 'todo'])->name('todo');

// Route::get('signin', function () {
//     return view('pages.signin');
// })->name('signin');
// Route::get('signup', function () {
//     return view('pages.signup');
// })->name('signup');
