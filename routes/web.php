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
    return redirect(route('login'));
});

Auth::routes();

Route::get('lang/{locale}', 'VerifyController@lang')->name('lang');

Route::get('/verify', 'VerifyController@show')->name('verify');
Route::post('/verify', 'VerifyController@verify')->name('verify');

Route::any('/home', 'HomeController@index')->name('home');
Route::get('/profile', 'HomeController@profile')->name('profile');

Route::get('/profile', 'UserController@profile')->name('profile');
Route::post('/updateuser', 'UserController@updateuser')->name('updateuser');
Route::get('/users/index', 'UserController@index')->name('users.index');
Route::post('/user/create', 'UserController@create')->name('user.create');
Route::post('/user/edit', 'UserController@edituser')->name('user.edit');
Route::get('/user/delete/{id}', 'UserController@delete')->name('user.delete');

Route::get('/category/index', 'CategoryController@index')->name('category.index');
Route::post('/category/create', 'CategoryController@create')->name('category.create');
Route::post('/category/edit', 'CategoryController@edit')->name('category.edit');
Route::get('/category/delete/{id}', 'CategoryController@delete')->name('category.delete');


Route::get('/account/index', 'AccountController@index')->name('account.index');
Route::post('/account/create', 'AccountController@create')->name('account.create');
Route::post('/account/edit', 'AccountController@edit')->name('account.edit');
Route::get('/account/delete/{id}', 'AccountController@delete')->name('account.delete');

Route::post('/accountgroup/create', 'AccountController@create_group')->name('accountgroup.create');
Route::post('/accountgroup/edit', 'AccountController@edit_group')->name('accountgroup.edit');
Route::get('/accountgroup/delete/{id}', 'AccountController@delete_group')->name('accountgroup.delete');


Route::any('/transaction/index', 'TransactionController@index')->name('transaction.index');
Route::get('/transaction/create', 'TransactionController@create')->name('transaction.create');
Route::post('/transaction/expense', 'TransactionController@expense')->name('transaction.expense');
Route::post('/transaction/incoming', 'TransactionController@incoming')->name('transaction.incoming');
Route::post('/transaction/transfer', 'TransactionController@transfer')->name('transaction.transfer');
Route::get('/transaction/edit', 'TransactionController@edit')->name('transaction.edit');
Route::post('/transaction/update', 'TransactionController@update')->name('transaction.update');
Route::get('/transaction/delete/{id}', 'TransactionController@delete')->name('transaction.delete');
