<?php

declare(strict_types=1);

namespace App\Infrastructure\Middleware;

use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Whoops\Handler\PrettyPageHandler;

final class ErrorMiddleware implements MiddlewareInterface
{
    public function __construct(
        private Psr17Factory $factory,
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $whoops = new \Whoops\Run();
        $whoops->allowQuit(false);
        $whoops->writeToOutput(false);
        $whoops->pushHandler(new PrettyPageHandler());

        try {
            return $handler->handle($request);
        } catch (\Throwable $e) {
            return $this->factory
                ->createResponse(500)
                ->withBody(
                    $this->factory->createStream($whoops->handleException($e))
                );
        }
    }
}
