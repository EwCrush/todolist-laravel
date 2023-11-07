<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ToDoController;
use JD\Cloudder\Facades\Cloudder;

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
    return Cloudder::show('sample');
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/tags', [ToDoController::class, 'getTags'])->name('getTags');
    Route::get('/lists', [ToDoController::class, 'getLists'])->name('getLists');
});

Route::post('/signin', [AuthController::class, 'handleSignin']);
Route::get('/signin', [AuthController::class, 'signin'])->name('signin');
Route::post('/signup', [AuthController::class, 'handleSignup']);
Route::get('/signup', [AuthController::class, 'signup'])->name('signup');

Route::middleware('todo')->prefix('todo')->group(function () {
    Route::get('/', [ToDoController::class, 'todo'])->name('todo');
    Route::get('/tasks/today', [ToDoController::class, 'today'])->name('today');
    Route::get('/tasks/next-7-days', [ToDoController::class, 'next7days'])->name('next7days');
    Route::get('/tasks/all', [ToDoController::class, 'alltasks'])->name('alltasks');
});