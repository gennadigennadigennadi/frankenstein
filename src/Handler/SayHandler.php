<?php

declare(strict_types=1);

namespace App\Handler;

use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final class SayHandler implements RequestHandlerInterface
{
    public function __construct(
        #[Autowire(service: Psr17Factory::class)] private ResponseFactoryInterface $responseFactory,
        #[Autowire(service: Psr17Factory::class)] private StreamFactoryInterface $streamFactory,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $id = $request->getAttribute('id');
        sleep(2);

        $responseBody = $this->streamFactory
            ->createStream('Id: '.$id);

        return $this->responseFactory
            ->createResponse(200)
            ->withBody($responseBody);
    }
}
