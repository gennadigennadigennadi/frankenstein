<?php

declare(strict_types=1);

namespace App;

use App\Factory\ContainerFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;

final class Application
{
    public function run(): void
    {
        $container = (new ContainerFactory())->build();

        $middleware = $container->get(MiddlewareInterface::class);
        $serverRequest = $container->get(ServerRequestInterface::class);

        (new SapiEmitter())->emit($middleware->handle($serverRequest));
    }
}
