<?php

Route::get('/', 'PostsController@index')->name('posts.index');
Route::resource('posts', 'PostsController')->except('index');
Route::get('categories/{category}', 'CategoriesController')->name('categories.show');
Route::get('tags/{tag}', 'TagsController')->name('tags.show');
