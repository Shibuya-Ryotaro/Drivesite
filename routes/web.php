<?php

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
    return view('top.index');
})->name('top.index');

Route::group(['prefix' => 'contact', 'as' => 'contact.'], function(){
    Route::get('/', 'ContactController@index')->name('index');
    Route::post('/', 'ContactController@index')->name('index.back');
    Route::get('edit/{id}', 'ContactController@edit')->name('edit');
    Route::delete('destroy/{id}/complete', 'ContactController@destroy')->name('destroy');
    Route::post('confirm', 'ContactController@confirm')->name('confirm');
    Route::post('complete', 'ContactController@create')->name('complete');
    Route::post('edit/{id}/complete', 'ContactController@update')->name('update');

    Route::match(['get'],'confirm', 'ContactController@index');
    Route::match(['get'],'destroy/{id}/complete', 'ContactController@index');
    Route::match(['get'],'complete', 'ContactController@index');
    Route::match(['get'],'edit/{id}/complete', 'ContactController@index');

// Route::get("/", "UserController@index")->name('index');
});


Route::middleware(['auth','can:isAdmin'])->group(function(){
    // Route::get('/admin','AdminController@index');
});


// middleware('throttle:3, 1'); 一分間に3回までのリクエストを受け付ける
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('posts/index','PostController@index')->name('posts.index');
Route::get('posts/show/{id}','PostController@show')->name('posts.show');


//ログインユーザーのみ
Route::group(['middleware' => 'auth'], function () {
    //この中に以前の記事で書いたルーティングのコードを書いていく
    //例えば
    Route::get('posts', 'PostController@create')->name('posts.create');
    Route::post('posts/store', 'PostController@store')->name('posts.store');
    Route::get('posts/edit/{id}','PostController@edit')->name('post.edit');
    Route::post('posts/update','PostController@update')->name('post.update');
    Route::post('posts/delete/{id}','PostController@delete')->name('post.delete');
    Route::post('comments/delete/{id}','CommentController@delete')->name('comments.delete');

    Route::post('comments/store', 'CommentController@store')->name('comments.store');
    
    Route::get('mylists/index','MyListController@index')->name('mylists.index');
    Route::post('mylists/store','MyListController@store')->name('mylists.store');
    Route::post('mylists/delete/{id}','MyListController@delete')->name('mylists.delete');

    Route::get('mylists/mylist','MyListController@mylist')->name('mylists.mylist');
});
  