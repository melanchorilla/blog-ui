<?php

use Illuminate\Support\Facades\{Route, Auth};
use App\Http\Controllers\Admin\{CategoryController, DashboardController, TagController, PostController};


Route::get('/', [App\Http\Controllers\PostController::class, 'index'])->name('posts');
Route::get('/posts', [App\Http\Controllers\PostController::class, 'index'])->name('posts');
Route::get('/post/{post:slug}', [App\Http\Controllers\PostController::class, 'show'])->name('post.show');
Route::view('about', 'about')->name('about');

Auth::routes();

Route::middleware('auth')->group(function () {

    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/{post:slug}', [DashboardController::class, 'show'])->name('dashboard.show');

        Route::resource('/categories', CategoryController::class);
        Route::get('/apicategory', [CategoryController::class, 'api_category'])->name('api.category');
        
        Route::resource('/tags', TagController::class);
        Route::get('/apitag', [TagController::class, 'api_tag'])->name('api.tag');
        
        Route::resource('/posts', PostController::class);
        Route::get('/apipost', [PostController::class, 'api_post'])->name('api.post');
    });
});




