<?php

// 项目根目录
Route::get('/', 'PagesController@root')->name('root');

// 用户认证
Auth::routes();


Route::resource('users', 'UsersController', ['only' => ['show', 'update', 'edit']]);
Route::get('/users/{user}', 'UsersController@show')->name('users.show');


Route::resource('topics', 'TopicsController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);