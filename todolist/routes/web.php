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
    Route::get('todo', function () {
        return view('pages.user.todo');
    });
});

Route::post('/signin', [AuthController::class, 'handleSignin']);
Route::get('/signin', [AuthController::class, 'signin'])->name('signin');
Route::post('/signup', [AuthController::class, 'handleSignin']);
Route::get('/signup', [AuthController::class, 'signup'])->name('signup');

// Route::get('signin', function () {
//     return view('pages.signin');
// })->name('signin');
// Route::get('signup', function () {
//     return view('pages.signup');
// })->name('signup');
