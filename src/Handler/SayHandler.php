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
        #[Autowire(service: Psr17Factory::class)]
        private ResponseFactoryInterface $responseFactoryInterface,
        #[Autowire(service: Psr17Factory::class)]
        private StreamFactoryInterface $streamFactoryInterface,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $id = $request->getAttribute('id');

        $responseBody = $this->streamFactoryInterface
            ->createStream('Id: '.$id);

        return $this->responseFactoryInterface
            ->createResponse(200)
            ->withBody($responseBody);
    }
}
