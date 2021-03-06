<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

$versionApiAttributes= [
    'prefix' => '/v1',
];

Route::group($versionApiAttributes, function ()  {
    Route::post('auth/register/', [AuthController::class , 'register']);
    Route::post('auth/login/', [AuthController::class, 'login']);


    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('users/me/', [UserController::class, 'me']);
        
        
        Route::get('categories/', [CategoryController::class, 'index']);

        Route::get('books/', [BookController::class, 'index']);
        Route::get('books/{book}', [BookController::class, 'show']);
        Route::post('books/', [BookController::class, 'store']);
        Route::put('books/{book}', [BookController::class, 'edit']);
        Route::delete('books/{book}', [BookController::class, 'delete']);
        Route::put('books/{book}/borrow', [BookController::class, 'borrow']);
        Route::put('books/{book}/return', [BookController::class, 'return']);
    });
});
