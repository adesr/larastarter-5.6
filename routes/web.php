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

Route::get('/', [ 'uses' => 'HomeCtrl@index' ]);
Route::post('login', 'UserCtrl@login');
Route::get('logout', function() {
    Auth::logout();
    session()->flush();
    return redirect('/');
});

Route::prefix('menus')->group(function() {
    Route::get('/', [ 'uses' => 'MenuCtrl@index', 'middleware' => 'permission:index menu' ]);
    Route::get('tree', [ 'uses' => 'MenuCtrl@tree', 'middleware' => 'permission:index menu' ]);
    Route::post('store', [ 'uses' => 'MenuCtrl@store', 'middleware' => 'permission:create menu|update menu' ]);
    Route::get('delete/{id}', [ 'uses' => 'MenuCtrl@destroy', 'middleware' => 'permission:delete menu' ]);
    Route::get('{type}/{id}', [ 'uses' => 'MenuCtrl@create', 'middleware' => 'permission:create menu|update menu' ]);
});
Route::prefix('roles')->group(function() {
    Route::get('/', [ 'uses' => 'RoleCtrl@index', 'middleware' => 'permission:index role' ]);
    Route::get('dt', [ 'uses' => 'RoleCtrl@dt', 'middleware' => 'permission:index role' ]);
    Route::get('create/{id?}', [ 'uses' => 'RoleCtrl@create', 'middleware' => 'permission:create role|update role' ]);
    Route::get('tree', [ 'uses' => 'RoleCtrl@tree', 'middleware' => 'permission:create role|update role' ]);
    Route::post('store', [ 'uses' => 'RoleCtrl@store', 'middleware' => 'permission:create role|update role' ]);
    Route::get('delete/{id}', [ 'uses' => 'RoleCtrl@destroy', 'middleware' => 'permission:delete role' ]);
});
Route::prefix('users')->group(function() {
    Route::get('/', [ 'uses' => 'UserCtrl@index', 'middleware' => 'permission:index user' ]);
    Route::get('dt', [ 'uses' => 'UserCtrl@dt', 'middleware' => 'permission:index user' ]);
    Route::get('create/{id?}', [ 'uses' => 'UserCtrl@create', 'middleware' => 'permission:create user|update user' ]);
    Route::post('store', [ 'uses' => 'UserCtrl@store', 'middleware' => 'permission:create user|update user' ]);
    Route::get('delete/{id}', [ 'uses' => 'UserCtrl@destroy', 'middleware' => 'permission:delete user' ]);
});
