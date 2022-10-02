<?php

declare(strict_types=1);

namespace App\Infrastucture\Middleware;

use DateTimeImmutable;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;


final class TimerMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $start = new DateTimeImmutable();
        $response = $handler->handle($request);
        $end = new DateTimeImmutable();

        setcookie('timer', $end->diff($start)->format('%f'));
        session_write_close();

        return $response;
    }
}
