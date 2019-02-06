<?php

// 项目根目录
Route::get('/', 'PagesController@root')->name('root');

// 用户认证
Auth::routes();

// 用户
Route::resource('users', 'UsersController', ['only' => ['show', 'update', 'edit']]);
Route::get('/users/{user}', 'UsersController@show')->name('users.show');

// 话题
Route::resource('topics', 'TopicsController', ['only' => ['index', 'create', 'store', 'update', 'edit', 'destroy']]);
// 话题 - 上传图片
Route::post('upload_image', 'TopicsController@uploadImage')->name('topics.upload_image');
// 话题- slug
Route::get('topics/{topic}/{slug?}', 'TopicsController@show')->name('topics.show');
// 话题 - 回复
Route::resource('replies', 'RepliesController', ['only' => ['store', 'destroy']]);
// 分类
Route::resource('categories', 'CategoriesController', ['only' => ['show']]);
