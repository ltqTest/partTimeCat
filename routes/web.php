<?php

// 项目根目录
Route::get('/', 'PagesController@root')->name('root');

// 用户认证
Auth::routes();


Route::resource('users', 'UsersController', ['only' => ['show', 'update', 'edit']]);

