<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
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

Route::get('/', [BlogController::class, 'index']);

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/posts', [PostController::class, 'index'])->name('posts');

Route::get('/post-create', [PostController::class, 'create'])->middleware('isBanned');

Route::post('/post-edit', [PostController::class, 'edit'])->middleware('isBanned');

Route::post('/post-posting', [PostController::class, 'posting'])->middleware('isBanned');

Route::post('/post-draft', [PostController::class, 'draft'])->middleware('isBanned');

Route::post('/post-delete', [PostController::class, 'destroy']);

Route::post('/post-store', [PostController::class, 'store'])->middleware('isBanned');

Route::post('/post-update', [PostController::class, 'update'])->middleware('isBanned');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories')->middleware('admin');

Route::post('/category-delete', [CategoryController::class, 'destroy'])->middleware('admin');

Route::post('/category-create', [CategoryController::class, 'store'])->middleware('admin');

Route::post('/category-edit', [CategoryController::class, 'edit'])->middleware('admin');

Route::post('/category-update', [CategoryController::class, 'update'])->middleware('admin');

Route::get('/post/{user}/{post_id}/{slug}', [BlogController::class, 'showPost']);

Route::get('/preview/{user}/{post_id}/{slug}', [BlogController::class, 'showPreview'])->middleware('auth');

Route::get('/category/{category}', [BlogController::class, 'showByCategory']);

Route::get('/tag/{tag}', [BlogController::class, 'showByTag']);

Route::get('/user/{user}', [BlogController::class, 'showByUser']);

Route::post('/search', [BlogController::class, 'search']);

Route::get('/users', [UserController::class, 'index'])->name('users')->middleware('admin');

Route::post('/user-banned', [UserController::class, 'userBanned'])->middleware('admin');

Route::post('/user-activate', [UserController::class, 'userActivate'])->middleware('admin');

Route::get('/profile', [UserController::class, 'userEdit'])->name('profile')->middleware('auth');

Route::post('/profile-update', [UserController::class, 'userUpdate'])->middleware('auth');