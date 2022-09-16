<?php

declare(strict_types=1);

namespace App\Factory;

use League\Route\Router;

final class RouterFactory
{
    public function __construct(
        private string $routes,
    ) {
    }

    public function build(): Router
    {
        $router = new Router();
        (require_once $this->routes)($router);

        return $router;
    }
}
