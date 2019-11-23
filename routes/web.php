<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//Route::get('/', 'HomeController@index')->name('home');

Route::get('/', 'HomeController@index')->name('home');
Route::get('/configuracion', 'UserController@config')->name('config');
Route::post('/user/update', 'UserController@update')->name('user.update');
Route::get('/user/avatar/{filename}', 'UserController@getImage')->name('user.avatar');
Route::get('/crear-imagen', 'ImageController@create')->name('image.create');
Route::post('/guardar-imagen', 'ImageController@save')->name('image.save');
Route::get('/imagen/file/{filename}', 'ImageController@getImage')->name('image.file');
Route::get('/imagen/detalle/{id}', 'ImageController@imageDetail')->name('image.detail');
Route::post('/comment/guardar', 'CommentController@save')->name('comment.save');
Route::get('/comment/delete/{id}', 'CommentController@delete')->name('comment.delete');
Route::get('/like/{image_id}', 'LikeController@like')->name('like');
Route::get('/dislike/{image_id}', 'LikeController@dislike')->name('dislike');
Route::get('/likes', 'LikeController@index')->name('likes');
Route::get('/perfil/{id}', 'UserController@profile')->name('profile');
Route::get('/imagen/borrar/{image_id}', 'ImageController@delete')->name('image.delete');
Route::get('/imagen/editar/{id}', 'ImageController@edit')->name('image.edit');
Route::post('/imagen/actualizar', 'ImageController@update')->name('image.update');
Route::get('/usuarios/{search?}', 'UserController@index')->name('user.index');