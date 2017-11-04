<?php

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

Route::resource('/platos', 'api\PlatoController', ['only' => ['index', 'show']] );
Route::get('/platos/categoria/{categoria}', ['uses' => 'api\PlatoController@category', 'as' => 'platos.category']);
Route::resource('/categorias', 'api\CategoriaPlatoController', ['only' => ['index', 'show']] );


Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/user', ['uses' => 'api\UserController@index', 'as' => 'user.me']);

    Route::resource('/personal', 'api\PersonalController', ['only' => ['index', 'show']] );
    Route::resource('/pedidos', 'api\PedidoController', ['except' => ['create', 'edit', 'despachar']] );
    Route::put('/pedidos/{pedido}/cobrar', ['uses' => 'api\PedidoController@cobrar', 'as' => 'pedidos.cobrar']);


    Route::group(['middleware' => 'role:2'], function () {
        Route::put('/pedidos/{pedido}/despachar', ['uses' => 'api\PedidoController@despachar', 'as' => 'pedidos.despachar']);

        Route::put('/disponibilidad/platos', ['uses' =>  'api\PlatoController@disponibilidad',  'as' => 'platos.disponibilidad'] );
        Route::get('/digest/pedidos/{categoria?}', ['uses' => 'api\PedidoController@digest', 'as' => 'pedidos.digest']);
    });


    Route::group(['middleware' => 'role:1'], function () {
        Route::resource('/personal', 'api\PersonalController', ['only' => ['store', 'update', 'destroy']] );
        Route::resource('/platos', 'api\PlatoController',  ['only' => ['store', 'update', 'destroy']] );
        Route::resource('/categorias', 'api\CategoriaPlatoController', ['only' => ['store', 'update']]);
    });
});


