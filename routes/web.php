<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->group(['prefix' => '/public'], function ($router) {

});

//superadmin
$router->post('/super/login', 'Super\AuthenticationController@login');
$router->group(['middleware' => 'auth:super', 'prefix' => '/super', 'namespace' => 'Super'], function ($router) {
    $router->get('/me', 'SuperController@index');
    $router->post('/team/add', 'SuperController@addTeam');

    //professionalPlayer
    $router->group(['prefix' => '/player'], function ($router) {
        $router->post('/added', 'SuperController@addPlayer');
        $router->post('/{id}/updated', 'SuperController@updatePlayer');
        $router->post('/exchange', 'SuperController@exchangePlayer');
        $router->delete('/{id}/deleted', 'SuperController@deletePlayer');
    });
    
    $router->group(['prefix' => '/news'], function ($router) {
        $router->post('/create', 'SuperController@createNews');
        $router->delete('/{id}/deleted', 'SuperController@deleteNews');
    });

    $router->group(['prefix' => '/tournament'], function ($router) {
        $router->post('/create', 'SuperController@addTournament');
    });

});

//user
$router->post('/gamer/login', 'Gamer\AuthController@login');
$router->post('/gamer/register', 'Gamer\AuthController@register');
$router->group(['middleware' => 'auth:gamer', 'prefix' => '/gamer', 'namespace' => 'Gamer'], function ($router) {
    $router->get('/me', 'GeneralGamerController@profile');
    $router->post('/add/pubgm', 'GeneralGamerController@addPubgm');
    $router->post('/add/statistics', 'GeneralGamerController@addStatistic');

    $router->post('/logout', 'AuthController@logout');

});

