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

// Route::prefix('comments')->group(function () {
//     Route::get('/', [CommentController::class, 'store']);

//     //get options for one product
//     Route::get('get-options/{product_id}', [OptionsController::class, 'getOptions']);
//     //set options for one product
//     Route::post('set-options', [OptionsController::class, 'setOptions']);
//     //insert new review(comment or vote or both)
    
//     //get list of all pending review
//     Route::get('review-pending-list', [CommentsController::class, 'getAllPendingComments']);
//     //change one review status
//     Route::post('status-change', [CommentsController::class, 'changeReviewStatus']);
// });

