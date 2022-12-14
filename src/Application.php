<?php

declare(strict_types=1);

namespace App;

use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class Application
{
    public function __construct(
        private readonly MiddlewareInterface $middleware,
        private readonly ServerRequestInterface $serverRequest,
    ) {
    }

    public function run(): void
    {
        $response = $this->middleware->process(
            $this->serverRequest,
            new class() implements RequestHandlerInterface {
                public function handle(ServerRequestInterface $request): ResponseInterface
                {
                    throw new \LogicException();
                }
            },
        );
        (new SapiEmitter())->emit($response);
    }
}
