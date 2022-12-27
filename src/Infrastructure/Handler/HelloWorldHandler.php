<?php

declare(strict_types=1);

namespace App\Infrastructure\Handler;

use App\Domain\Generator\HelloGenerator;
use App\Domain\Generator\StringGenerator;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final class HelloWorldHandler implements RequestHandlerInterface
{
    public function __construct(
        #[Autowire(service: HelloGenerator::class)] private StringGenerator $stringGenerator,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new Response(body: $this->stringGenerator->generate());
    }
}
