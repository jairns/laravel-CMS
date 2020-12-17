<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;


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
    return view('blog');
});

Route::get('/about', function () {
    return view('about');
});

// Route::get('/test/{title}/{description}', 'App\Http\Controllers\PostController@index');
Route::resource('post', 'App\Http\Controllers\PostController');
Route::resource('tag', 'App\Http\Controllers\TagController');
Route::resource('user', 'App\Http\Controllers\UserController');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/post/tag/{tag_id}', [App\Http\Controllers\PostTagController::class, 'getFilterPosts'])->name('post_tag');

// Add tag[s] to post[s]
Route::get('/post/{post_id}/tag/{tag_id}/assign', [App\Http\Controllers\PostTagController::class, 'assignTag']);
// Remove tag[s] from post[s]
Route::get('/post/{post_id}/tag/{tag_id}/remove', [App\Http\Controllers\PostTagController::class, 'removeTag']);