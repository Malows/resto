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

Route::view('/', 'public');
 
Auth::routes();
Route::group(['middleware' => ['web','guest']], function () {
    Route::get('/qr_login', ['uses' => 'Auth\QrLoginController@index', 'as' => 'view_qr_login']);
    Route::get('/qr_login_2', ['uses' => 'Auth\QrLoginController@indexoption2', 'as' => 'view_qr_login_2']);

    Route::post('/qr_login', ['uses' => 'Auth\QrLoginController@checkUser', 'as' => 'attempt_qr_login']);
});


Route::get('/inicio', 'HomeController@index')->name('home');
Route::redirect('/home', '/inicio');

Route::group(['middleware' => 'auth'], function () {

    Route::group(['prefix' => 'pedidos', 'middleware' => 'role:3'], function () {
//        Route::resource('/mesas', 'PedidoController',  ['except' => [ 'create', 'edit', 'show'] ] );
//        Route::put('/mesas/{id}/cobrar', ['uses' => 'PedidoController@cobrar', 'as' => 'mesas.cobrar']);

        Route::group(['middleware' => 'role:2'], function () {
//            Route::get('/', ['uses' => 'PedidoController@index_cocina', 'as' => 'pedidos.index']);
//            Route::put('/despachar/{id}', ['uses' => 'PedidoController@despachar', 'as' => 'pedidos.dispatch']);
//            Route::get('/lista', ['uses' => 'PedidoController@index_digest', 'as' => 'pedidos.digest']);
//            Route::get('/lista/{categoria}', ['uses' => 'PedidoController@index_target_digest', 'as' => 'pedidos.target_digest']);
        });
    });
    Route::group(['prefix' => 'disponibilidad', 'middleware' => 'role:2'], function () {
//        Route::get('/platos', ['uses' => 'PlatoController@disponibilidad', 'as' => 'disponibilidad']);
//        Route::put('/platos/guardar', ['uses' => 'PlatoController@actualizar_disponibilidad', 'as' => 'guardar_disponibilidad']);
    });

    Route:: group(['prefix' => 'administracion', 'middleware' => 'role:1'], function () {
//        Route::resource('platos', 'PlatoController',  ['except' => [ 'create', 'edit', 'show'] ] );
//        Route::resource('personal', 'UserController', ['except' => [ 'create', 'edit', 'show'] ] );
    });

});
