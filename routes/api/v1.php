<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\VoteController;
use App\Http\Controllers\Api\V1\CommentController;
use App\Http\Controllers\Api\V1\ProductController;

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

Route::prefix('products')->as('products.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/{id}', [ProductController::class, 'show'])->name('show');
    Route::put('/{id}', [ProductController::class, 'update'])->name('update');
});

Route::prefix('reviews')->as('review.')->group(function () {
    Route::post('votes', [VoteController::class, 'store'])->name('store');
    Route::put('votes/{id}', [ReviewController::class, 'changeStatus'])->name('change-status');

    Route::post('comments', [CommentController::class, 'store'])->name('store');
    Route::put('comments/{id}/change-status', [CommentController::class, 'changeStatus'])->name('change-status');
});
