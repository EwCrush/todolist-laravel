<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ToDoController;
use App\Http\Controllers\UserListController;
use App\Http\Controllers\TaskDescriptionController;
use App\Http\Controllers\TagController;
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

Route::get('/', [AuthController::class, 'home'])->name('home');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/tags', [ToDoController::class, 'getTags'])->name('getTags');
    Route::get('/lists', [ToDoController::class, 'getLists'])->name('getLists');
    Route::put('/profile', [AuthController::class, 'editProfile'])->name('editProfile');
    Route::put('/password', [AuthController::class, 'changePassword'])->name('changePassword');
});

Route::post('/signin', [AuthController::class, 'handleSignin']);
Route::get('/signin', [AuthController::class, 'signin'])->name('signin');
Route::post('/signup', [AuthController::class, 'handleSignup']);
Route::get('/signup', [AuthController::class, 'signup'])->name('signup');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

//socialite
Route::get('/auth/{social}', [AuthController::class, 'socialLogin'])->name('socialLogin');
Route::get('/auth/{social}/callback', [AuthController::class, 'socialLoginHandle'])->name('socialLoginHandle');

Route::middleware('todo')->prefix('todo')->group(function () {
    Route::get('/', [ToDoController::class, 'todo'])->name('todo');
    Route::get('/list/today', [ToDoController::class, 'today'])->name('today');
    Route::get('/list/next-7-days', [ToDoController::class, 'next7days'])->name('next7days');
    Route::get('/list/all', [ToDoController::class, 'alltasks'])->name('alltasks');
    Route::get('/list/custom/{id}', [ToDoController::class, 'customList'])->name('customList');
    Route::get('/tag/{id}', [ToDoController::class, 'tasksByTag'])->name('tasksByTag');
    Route::get('/list/trash', [ToDoController::class, 'getTrash'])->name('getTrash');
    Route::get('/list/completed', [ToDoController::class, 'getCompleted'])->name('getCompleted');
    Route::put('/task/trash/{id}', [ToDoController::class, 'putToTrash'])->name('putToTrash');
    Route::put('/task/restore/{id}', [ToDoController::class, 'restore'])->name('restore');
    Route::delete('/task/delete/{id}', [ToDoController::class, 'deleteTask'])->name('deleteTask');
    Route::put('/task/completed/{id}', [ToDoController::class, 'checkCompleted'])->name('checkCompleted');
    Route::post('/task', [ToDoController::class, 'addNewTask'])->name('addNewTask');
    Route::post('/list', [UserListController::class, 'addNewList'])->name('addNewList');
    Route::post('/tag', [TagController::class, 'addNewTag'])->name('addNewTag');
    Route::post('/image', [AuthController::class, 'uploadImg'])->name('uploadImg');
    Route::get('/task/{id}', [TaskDescriptionController::class, 'getTaskDescription'])->name('getTaskDescription');
    Route::delete('/task/{taskid}/tag/{tagid}', [TaskDescriptionController::class, 'removeTagFromTask'])->name('removeTagFromTask');
    Route::post('/task/{taskid}/tag/{tagid}', [TaskDescriptionController::class, 'addTagToTask'])->name('addTagToTask');
    Route::put('/task/{taskid}/list/{listid}', [TaskDescriptionController::class, 'changeListTask'])->name('changeListTask');
    Route::put('/task/{id}/date', [TaskDescriptionController::class, 'changeDateTask'])->name('changeDateTask');
    Route::put('/task/{id}/description', [TaskDescriptionController::class, 'changeDescriptionTask'])->name('changeDescriptionTask');
    Route::put('/task/{id}/title', [TaskDescriptionController::class, 'changeTitleTask'])->name('changeTitleTask');
    Route::delete('/tag/{id}', [TagController::class, 'deleteTag'])->name('deleteTag');
    Route::delete('/list/{id}', [UserListController::class, 'deleteList'])->name('deleteList');
});