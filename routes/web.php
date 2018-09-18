<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('posts/create', 'PostsController@create')->name('posts.create');
Route::get('posts/{post}', 'PostsController@show')->name('posts.show');
Route::post('posts', 'PostsController@store')->name('posts.store');
