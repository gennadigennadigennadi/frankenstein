<?php

use League\Route\Router;
use App\Handler\HelloWorldHandler;
use App\Handler\SayHandler;

return static function (Router $router) {
    $router->get('/', [HelloWorldHandler::class, 'handle']);
    $router->get('/word/{id}', [SayHandler::class, 'handle']);
};
