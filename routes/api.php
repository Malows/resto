<?php

use Illuminate\Http\Request;

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
//Route::get('/redirect', function () {
//    $query = http_build_query([
//        'client_id' => '3',
//        'redirect_uri' => 'http://192.168.1.236:8000/api/callback',
//        'response_type' => 'token',
//        'scope' => '',
//    ]);
//
//    return redirect('http://192.168.1.236:8000/oauth/authorize?'.$query);
//});

Route::get('/platos', ['uses' => 'api\PlatoController@index', 'as' => 'api.platos.index']);
Route::get('/platos/{id}', ['uses' => 'api\PlatoController@show', 'as' => 'api.platos.show']);
Route::get('/platos/categoria/{id}', ['uses' => 'api\PlatoController@category', 'as' => 'api.platos.category']);

Route::get('/categorias', ['uses' => 'api\CategoriaPlatoController@index', 'as' => 'api.categorias.index']);
Route::get('/categorias/{id}', ['uses' => 'api\CategoriaPlatoController@show', 'as' => 'api.categorias.show']);


Route::get('/personal', ['uses' => 'api\PersonalController@index', 'as' => 'api.personal.index']);
Route::get('/personal/{id}', ['uses' => 'api\PersonalController@show', 'as' => 'api.personal.show']);

Route::get('/pedidos', ['uses' => 'api\PedidoController@index', 'as' => 'api.pedidos.index']);
Route::get('/pedidos/{id}', ['uses' => 'api\PedidoController@show', 'as' => 'api.pedidos.show']);

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/user', ['uses' => 'api\UserController@index', 'as' => 'user.me']);
});
