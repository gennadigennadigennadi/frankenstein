<?php

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
        $serverRequest = (new ServerRequestFactory())->build();
        $container = (new ContainerFactory())->build();
        $router = $container->get(Router::class);

        (require_once __DIR__ . '/../config/routes.php')($router);

        $pipe = new MiddlewarePipe();
        $pipe->pipe(new ErrorMiddleware());
        $pipe->pipe(new RouterMiddleware($router, $container));

        echo $pipe->handle($serverRequest)->getBody();
    }
}
