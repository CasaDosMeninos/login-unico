<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/


$app->get('/',          ['as' => 'home', function () use ($app) { return $app->make('view')->make('index'); }]);
$app->get('sistemas',   ['as' => 'sistemas', function () use ($app) { return $app->make('view')->make('index'); }]);

$app->get('cadastro',   ['uses' => 'CadastroController@get', 'as' => 'cadastro']);
$app->post('cadastro',  ['uses' => 'CadastroController@post', 'as' => 'cadastro-post']);

$app->get('login',      ['uses' => 'AdminController@login', 'as' => 'login']);

$app->group(['prefix' => 'admin', 'middleware' => 'auth', 'namespace' => 'App\Http\Controllers'], function () use ($app) {
    $app->get('/', ['uses' => 'AdminController@index', 'as' => 'admin']);
    $app->post('/', ['uses' => 'AdminController@index']);
    $app->get('view/{email}', ['uses' => 'AdminController@view']);
    $app->get('delete/{email}', ['uses' => 'AdminController@delete']);
});