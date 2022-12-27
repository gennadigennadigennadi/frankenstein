<?php

declare(strict_types=1);

namespace App\Infrastructure\Factory;

use App\Infrastructure\Middleware\ErrorMiddleware;
use App\Infrastructure\Middleware\RequestHandlerMiddleware;
use App\Infrastructure\Middleware\SessionMiddleware;
use App\Infrastructure\Middleware\TimerMiddleware;
use Laminas\Stratigility\MiddlewarePipe;
use Psr\Http\Server\MiddlewareInterface;

final class MiddlewareFactory
{
    public function __construct(
        private ErrorMiddleware $errorMiddleware,
        private TimerMiddleware $timerMiddleware,
        private SessionMiddleware $sessionMiddleware,
        private RequestHandlerMiddleware $requestHandlerMiddleware,
    ) {
    }

    public function build(): MiddlewareInterface
    {
        $pipe = new MiddlewarePipe();

        $pipe->pipe($this->errorMiddleware);
        $pipe->pipe($this->timerMiddleware);
        $pipe->pipe($this->sessionMiddleware);
        $pipe->pipe($this->requestHandlerMiddleware);

        return $pipe;
    }
}
