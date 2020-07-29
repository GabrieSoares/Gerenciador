<?php

use \App\Http\Controllers\ctrlFinanController;

$router->group(['prefix' => "/api/v1/ctrlF"], function() use ($router){
    $router -> get("/{month}/{user}", "ctrlFinanController@getAll");
    $router -> get("/Details/{id}/{user}", "ctrlFinanController@get");
    $router -> post("/", "ctrlFinanController@create");
    $router -> put("/{id}", "ctrlFinanController@Update");
    $router -> delete("/{id}", "ctrlFinanController@Delete");
});

$router->group(['prefix' => "/api/v1/user/"], function() use ($router){
    $router -> get("/{month}/{user}", "crtlFinanController@getAll");
    $router -> get("/Details/{id}/{user}", "crtlFinanController@get");
    $router -> post("/", "crtlFinanController@create");
});
$router->get('', "crtlFinanController@getAll");