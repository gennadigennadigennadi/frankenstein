<?php

declare(strict_types=1);

use App\Handler\HelloWorldHandler;
use App\Handler\SayHandler;
use League\Route\Router;

return static function (Router $router): void {
    $router->get('/', [HelloWorldHandler::class, 'handle']);
    $router->get('/word/{id}', [SayHandler::class, 'handle']);
};
