<?php

namespace App\Handler;

use App\Generator\StringGenerator;
use Nyholm\Psr7\Factory\Psr17Factory;
use App\Generator\RandomTextGenerator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final class HelloWorldHandler implements RequestHandlerInterface
{
    public function __construct(
        #[Autowire(service: RandomTextGenerator::class)]
        private StringGenerator $stringGenerator,
        private Psr17Factory $psr17Factory,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $responseBody = $this->psr17Factory
            ->createStream(
                $this->stringGenerator->generate()
            );

        $response = $this->psr17Factory
            ->createResponse(200)
            ->withBody($responseBody);

        return $response;
    }
}
