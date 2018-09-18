<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('posts/create', '\Blog\Http\Controllers\PostsController@create')->name('posts.create');
Route::get('posts/{post}', '\Blog\Http\Controllers\PostsController@show')->name('posts.show');
Route::post('posts', '\Blog\Http\Controllers\PostsController@store')->name('posts.store');
