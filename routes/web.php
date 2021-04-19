<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::prefix('posts')->middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::get('/', [PostController::class, 'index'])
        ->name('posts.index');

    Route::get('/create', [PostController::class, 'create'])
        ->name('posts.create');

    Route::post('/', [PostController::class, 'store'])
        ->name('posts.store');

    Route::get('/{post:slug}', [PostController::class, 'show'])
        ->name('posts.show');

    Route::prefix('{post}')->group(function () {

        Route::get('/edit', [PostController::class, 'edit'])
            ->name('posts.edit');

        Route::put('/', [PostController::class, 'update'])
            ->name('posts.update');

        Route::delete('/', [PostController::class, 'destroy'])
            ->name('posts.destroy');

        Route::prefix('comments')->group(function () {

            Route::get('/create', [CommentController::class, 'create'])
                ->name('posts.comments.create');

            Route::post('/', [CommentController::class, 'store'])
                ->name('posts.comments.store');

            Route::post('/{comment}/replies', [CommentController::class, 'repliesStore'])
                ->name('posts.comments.replies.store');
        });
    });
});

Route::prefix('comments/{comment}')->middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::get('/edit', [CommentController::class, 'edit'])
        ->name('comments.edit');

    Route::put('/', [CommentController::class, 'update'])
        ->name('comments.update');

    Route::delete('/', [CommentController::class, 'destroy'])
        ->name('comments.destroy');
});
