<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ========================Books route=========================
Route::get('/books',[BooksController::class,'getBook']);
Route::post('/books',[BooksController::class,'createBook']);
Route::post('/books/{id}',[BooksController::class,'updateBook']);
Route::delete('/books/{id}',[BooksController::class,'delete']);

// =========================Search book=========================
Route::get('/book/search/{title}',[BooksController::class, 'search']);

// ========================User route=========================
Route::get('/users',[UserController::class,'getUsers']);
Route::post('/users',[UserController::class,'CreateUser']);
Route::post('/users/{id}',[UserController::class,'updateUser']);
Route::delete('/users/{id}',[UserController::class,'delete']);
Route::post('/login', [UserController::class, 'Login']);
Route::post('/logout', [UserController::class, 'Logout']);
// =========================Search user=========================
Route::get('/user/search/{title}',[UserController::class, 'search']);