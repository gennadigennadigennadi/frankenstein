<?php

declare(strict_types=1);

namespace App\Factory;

use League\Route\Router;
use League\Route\Strategy\ApplicationStrategy;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class RequestHandlerFactory
{
    public function __construct(
        private ContainerInterface $container,
        private string $configDir,
    ) {
    }

    public function build(): RequestHandlerInterface
    {
        $strategy = new ApplicationStrategy();
        $strategy->setContainer($this->container);

        $router = new Router();
        $router->setStrategy($strategy);
        (require $this->configDir.'/routes.php')($router);

        return $router;
    }
}
