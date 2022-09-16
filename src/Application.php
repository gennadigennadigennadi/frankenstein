<?php

declare(strict_types=1);

namespace App;

use App\Factory\ContainerFactory;
use App\Factory\ServerRequestFactory;
use App\Middleware\ErrorMiddleware;
use App\Middleware\RouterMiddleware;
use Laminas\Stratigility\MiddlewarePipe;
use League\Route\Router;

final class Application
{
    public function run(): void
    {
        $container = (new ContainerFactory())->build();
        $serverRequest = (new ServerRequestFactory())->build();
        $router = $container->get(Router::class);

        $pipe = new MiddlewarePipe();
        $pipe->pipe(new ErrorMiddleware());
        $pipe->pipe(new RouterMiddleware($router, $container));

        echo $pipe->handle($serverRequest)->getBody();
    }
}
