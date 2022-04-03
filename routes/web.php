<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\PostController;
use App\Models\Post;
use League\CommonMark\Parser\Block\BlockContinue;

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

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/posts', [PostController::class, 'index'])->name('posts');

Route::get('/post-create', [PostController::class, 'create']);

Route::post('/post-edit', [PostController::class, 'edit']);

Route::post('/post-posting', [PostController::class, 'posting']);

Route::post('/post-draft', [PostController::class, 'draft']);

Route::post('/post-delete', [PostController::class, 'destroy']);

Route::post('/post-store', [PostController::class, 'store']);