<?php

declare(strict_types=1);

use League\Route\Router;
use App\Handler\HelloWorldHandler;
use App\Handler\SayHandler;

return static function (Router $router): void {
    $router->get('/', [HelloWorldHandler::class, 'handle']);
    $router->get('/word/{id}', [SayHandler::class, 'handle']);
};
