<?php

Route::as('api.')->group(function () {
    Route::post('login', 'LoginController@login')->name('login');
    Route::resource('posts', 'PostsController')->except('create', 'edit');
    Route::get('categories/{category}', 'CategoriesController')->name('categories.show');
    Route::get('tags/{tag}', 'TagsController')->name('tags.show');
});
