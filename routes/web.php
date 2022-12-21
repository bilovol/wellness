<?php

/** @var Route $router */

use Illuminate\Support\Facades\Route;

$router->get('/', 'HomeController');

$router->group(['prefix' => 'wellness', 'namespace' => 'Wellness', 'middleware' => 'wellness'], function () use ($router) {
    $router->post('/contacts', 'ContactController@store');
    $router->get('/contacts/{contactId}', 'ContactController@show');
    $router->post('/contacts/subscribe', 'SubscriberController@subscribe');
    $router->post('/contacts/unsubscribe', 'SubscriberController@unsubscribe');
});


