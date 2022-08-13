<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\PostController;
use App\Http\Controllers\Dashboard\PostController as DashBoardPostController;

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

Auth::routes();

Route::get('/', [PostController::class, 'index'])->name('post.index');
Route::get('post/{id}', [PostController::class, 'show'])->name('post.show');

Route::group([
    'middleware' => ['auth'],
    'prefix'     => 'dashboard',
    'as'         => 'dashboard.',
], function () {
    Route::get('/', [DashBoardPostController::class, 'index'])->name('post.index');
    Route::get('post/create', [DashBoardPostController::class, 'create'])->name('post.create');
    Route::post('post/store', [DashBoardPostController::class, 'store'])->name('post.store');
    Route::get('post/{id}', [DashBoardPostController::class, 'show'])->name('post.show');
});

