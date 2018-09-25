<?php

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/', '\Blog\Http\Controllers\PostsController@index')->name('posts.index');
Route::get('posts/create', '\Blog\Http\Controllers\PostsController@create')->name('posts.create');
Route::get('posts/{post}', '\Blog\Http\Controllers\PostsController@show')->name('posts.show');
Route::post('posts', '\Blog\Http\Controllers\PostsController@store')->name('posts.store');

Route::get('posts/{post}/edit', '\Blog\Http\Controllers\PostsController@edit')->name('posts.edit');
Route::patch('posts/{post}', '\Blog\Http\Controllers\PostsController@update')->name('posts.update');
