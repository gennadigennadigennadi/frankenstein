<?php

namespace App\Middleware;

use League\Route\Router;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use League\Route\Strategy\ApplicationStrategy;

final class RouterMiddleware implements MiddlewareInterface
{
	public function __construct(
		private Router $router,
		private ContainerInterface $container,
	) {
	}
	public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
	{
		$strategy = new ApplicationStrategy();
		$strategy->setContainer($this->container);

		$this->router->setStrategy($strategy);

		return $this->router->dispatch($request);
	}
}
