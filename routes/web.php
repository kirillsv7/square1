<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\PostController;
use App\Http\Controllers\Dashboard\DashboardController;

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
], function () {
    Route::get('dashboard', [DashboardController::class, 'index']);
});

