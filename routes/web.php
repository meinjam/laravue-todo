<?php

use Illuminate\Support\Facades\Route;

Route::get( '/', function () {
    return view( 'welcome' );
} );

// Route::get( 'get_post/{id}', 'TodoController@edit' );
Route::resource( 'todo', 'TodoController' )->only( ['index', 'store'] );
Route::post( 'edit_todo', 'TodoController@update' );
Route::post( 'delete_todo', 'TodoController@destroy' );
Route::post( 'markcomplete', 'TodoController@markcomplete' );
Route::post( 'markincomplete', 'TodoController@markincomplete' );

Auth::routes();

Route::get( '/home', 'HomeController@index' )->name( 'home' );
