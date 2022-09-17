<?php

declare(strict_types=1);

namespace App\Factory;

use App\Middleware\ErrorMiddleware;
use App\Middleware\RequestHandlerMiddleware;
use Laminas\Stratigility\MiddlewarePipe;
use Psr\Http\Server\MiddlewareInterface;

final class MiddlewareFactory
{
    public function __construct(
        private ErrorMiddleware $errorMiddleware,
        private RequestHandlerMiddleware $requestHandlerMiddleware,
    ) {
    }

    public function build(): MiddlewareInterface
    {
        $pipe = new MiddlewarePipe();

        $pipe->pipe($this->errorMiddleware);
        $pipe->pipe($this->requestHandlerMiddleware);

        return $pipe;
    }
}
