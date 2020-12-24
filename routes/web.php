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
    return view('about');
});


// Route::get('/test/{title}/{description}', 'App\Http\Controllers\PostController@index');

Route::resource('post', 'App\Http\Controllers\PostController');
// Applied admin middleware to the tag route, therefore, only admins can utilise the functionality
Route::resource('tag', 'App\Http\Controllers\TagController')->middleware('admin');
Route::resource('user', 'App\Http\Controllers\UserController');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Search for posts
// Route::get('/post/search/', [App\Http\Controllers\PostController::class, 'searchPosts'])->name('search_posts');

// Filter posts by tag
Route::get('/post/tag/{tag_id}', [App\Http\Controllers\PostTagController::class, 'getFilterPosts'])->name('post_tag');

// Remove tag[s] from post[s] and applying middleware so only an authorized user can assign tags
Route::get('/post/{post_id}/tag/{tag_id}/assign', [App\Http\Controllers\PostTagController::class, 'assignTag'])->middleware('auth');
// Remove tag[s] from post[s] and applying middleware so only an authorized user can remove tags
Route::get('/post/{post_id}/tag/{tag_id}/remove', [App\Http\Controllers\PostTagController::class, 'removeTag'])->middleware('auth');;

// Remove image from post
Route::get('/remove-image/post/{post_id}', [App\Http\Controllers\PostController::class, 'removeImage']);
// Remove user profile pic
Route::get('/remove-image/user/{user_id}', [App\Http\Controllers\UserController::class, 'removeImage']);

// Add comments to post
Route::post('/comment/{post_id}', [App\Http\Controllers\CommentController::class, 'store']);
// Delete comment
Route::delete('/comment/remove/{comment_id}', [App\Http\Controllers\CommentController::class, 'destroy']);
