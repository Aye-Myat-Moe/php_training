<?php

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
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

Auth::routes(['register' => false]);

Route::get('/post/download', 'Post\PostController@downloadPostCSV')->name('downloadPostCSV');

Route::get('/', function () {
  return redirect()->route('postlist');
});
Route::get('/home', 'Home\HomeController@index')->name('home');

// vistor, user, admin authorized
Route::get('/post/list', 'Post\PostController@showPostList')->name('postlist');

// user, admin authorized
Route::group(['middleware' => ['auth']], function () {
  Route::get('/post/create', 'Post\PostController@showPostCreateView')->name('create.post');
  Route::post('/post/create', 'Post\PostController@submitPostCreateView')->name('create.post');
  Route::get('/post/create/confirm', 'Post\PostController@showPostCreateConfirmView')->name('post.create.confirm');
  Route::post('/post/create/confirm', 'Post\PostController@submitPostCreateConfirmView')->name('post.create.confirm');
  Route::delete('/post/delete/{postId}', 'Post\PostController@deletePostById');
  Route::get('/post/edit/{postId}', 'Post\PostController@showPostEdit')->name('post.edit');
  Route::post('/post/edit/{postId}', 'Post\PostController@submitPostEditView')->name('post.edit');
  Route::get('/post/edit/{postId}/confirm', 'Post\PostController@showPostEditConfirmView')->name('post.edit.confirm');
  Route::post('/post/edit/{postId}/confirm', 'Post\PostController@submitPostEditConfirmView')->name('submitPostEditConfirmView');
  Route::get('/post/upload', 'Post\PostController@showPostUploadView')->name('post.upload');
  Route::post('/post/upload', 'Post\PostController@submitPostUploadView')->name('post.upload');
  Route::get('/user/change-password', 'User\UserController@showChangePasswordView')->name('change.password');
  Route::post('/user/change-password', 'User\UserController@savePassword')->name('change.password');
});
// user, admin authorized
Route::group(['middleware' => ['auth']], function () {
  Route::get('/profile/{userId}/{profileName}', 'File\FileController@getUserProfile')->name('profile.photo');
  Route::get('/user/profile', 'User\UserController@showUserProfile')->name('profile');
  Route::get('/user/profile/edit', 'User\UserController@showUserProfileEdit')->name('profile.edit');
  Route::post('/user/profile/edit', 'User\UserController@submitEditProfileView')->name('profile.edit');
  Route::get('/user/profile/edit/confirm', 'User\UserController@showEditProfileConfirmView')->name('profile.edit.confirm');
  Route::post('/user/profile/edit/confirm', 'User\UserController@submitProfileEditConfirmView')->name('profile.edit.confirm');
});
// only admin authorized
Route::group(['middleware' => ['admin']], function () {
  Route::get('/user/list', 'User\UserController@showUserList')->name('userlist');
  Route::get('user/register', 'Auth\RegisterController@showRegistrationView')->name('register');
  Route::post('user/register', 'Auth\RegisterController@submitRegistrationView')->name('register');
  Route::get('user/register/confirm', 'Auth\RegisterController@showRegistrationConfirmView')->name('register.confirm');
  Route::post('user/register/confirm', 'Auth\RegisterController@submitRegistrationConfirmView')->name('registerConfirm');
  Route::delete('/user/delete/{userId}', 'User\UserController@deleteUserById');
});

Route::get('/vue', function () {
  return view('vue_index');
});

Route::get('/vue/{first_uri}', function () {
  return view('vue_index');
});

Route::get('/vue/{first_uri}/{second_uri}', function () {
  return view('vue_index');
});
Route::get('/vue/{first_uri}/{second_uri}/{third_uri}', function () {
  return view('vue_index');
});
