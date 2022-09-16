<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use App\Factory\RouterFactory;
use League\Route\Router;
use Nyholm\Psr7\Factory\Psr17Factory;

use Psr\Container\ContainerInterface;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $container): void {
    $container
        ->parameters()
        ->set('config', __DIR__) ;

    $services = $container->services();
    $services->defaults()
        ->autoconfigure()
        ->autowire()
    ;

    $services
        ->load('App\\', '../src/*')
        ->exclude('../src/{Entity,Tests,Application.php}');

    $services
        ->alias(ContainerInterface::class, 'service_container');

    $services
        ->set(Psr17Factory::class);

    $services
        ->set(RouterFactory::class)
        ->arg('$routes', __DIR__ . '/routes.php');

    $services
        ->set(Router::class)
        ->factory([service(RouterFactory::class), 'build']);
};
