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

Auth::routes();

Route::get('login/google', 'Auth\LoginController@redirectToGoogle');
Route::get('login/google/callback', 'Auth\LoginController@handleGoogleCallback');

Route::group(['middleware' => 'auth'], function () {
    Route::get('auth/edit', 'UserController@edit')->name('auth.edit');
    Route::post('auth/update', 'UserController@update');
    Route::get('auth/delete', 'UserController@show')->name('auth.delete');
    Route::get('auth/destroy', 'UserController@destroy')->name('auth_destroy');
});

Route::get('/', 'BookController@index')->name('index');
Route::get('books_genre', 'BookController@booksGenre');
Route::get('comics_genre', 'BookController@comicsGenre');
Route::get('magazines_genre', 'BookController@magazinesGenre');
Route::get('foreign_books_genre', 'BookController@foreignBooksGenre');
Route::get('search', 'BookController@search');
Route::get('ranking_order', 'BookController@rankingOrder');
Route::get('issue_date_order', 'BookController@issueDateOrder');
Route::get('price_order', 'BookController@priceOrder');
Route::get('book/{book}', 'BookController@show')->name('book');
Route::get('cart', 'CartController@index')->name('cart');

Route::post('cart_update', 'CartController@update')->name('update');
Route::delete('cart/{cart}', 'CartController@destroy')->name('delete');
Route::post('cart_store', 'CartController@store')->name('cart_store');

Route::match(['get', 'post'], 'address_edit', 'PurchaseController@edit')->name('address_edit');
Route::post('address_control', 'PurchaseController@address_control');
Route::get('checkout', 'PurchaseController@checkout');
