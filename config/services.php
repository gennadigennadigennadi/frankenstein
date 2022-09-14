<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use League\Route\Router;
use Nyholm\Psr7\Factory\Psr17Factory;

return static function (ContainerConfigurator $container) {
    $services = $container->services();
    $services->defaults()
        ->autoconfigure()
        ->autowire()
        ->public();

    $services
        ->load('App\\', '../src/*')
        ->exclude('../src/{Entity,Tests,Middleware,Application.php}');

    $services->set(Psr17Factory::class);
    $services->set(Router::class);
};
