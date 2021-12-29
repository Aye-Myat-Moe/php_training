<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// no authorization.
Route::group([], function () {
  Route::get('/post/list', 'API\Post\PostAPIController@getPostList');
});

// can access authorized user or admin.
Route::group([
  'middleware' => 'auth_api'
], function () {
  Route::get('/profile/{userId}/{profileName}', 'File\FileController@getUserProfileViaAPI');
  Route::get('/user/profile', 'API\User\UserAPIController@getUserProfile');
  Route::post('/user/profile/edit', 'API\User\UserAPIController@updateUser');
  Route::post('/user/change-password', 'API\User\UserAPIController@savePassword');
  Route::get('/post/{postId}', 'API\Post\PostAPIController@getPostById');
  Route::post('/post/create', 'API\Post\PostAPIController@createPost');
  Route::post('/post/upload', 'API\Post\PostAPIController@uploadPostCSVFile');
  Route::post('/post/edit/{postId}', 'API\Post\PostAPIController@updatePost');
  Route::delete('/post/delete/{postId}', 'API\Post\PostAPIController@deletePostById');
});

// can access only admin.
Route::group([
  'middleware' => 'admin_api'
], function () {
  Route::post('/user/create', 'API\User\UserAPIController@createUser');
  Route::get('/user/list', 'API\User\UserAPIController@getUserList');
  Route::delete('/user/delete/{userId}', 'API\User\UserAPIController@deleteUserById');
});

// for authenticatiion route.
Route::group([
  'prefix' => 'auth'
], function () {
  Route::post('login', 'API\Auth\AuthAPIController@login');

  Route::group([
    'middleware' => 'auth_api'
  ], function () {
    Route::post('logout', 'API\Auth\AuthAPIController@logout');
  });
});
