<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use App\Factory\MiddlewareFactory;
use App\Factory\RequestHandlerFactory;
use App\Factory\ServerRequestFactory;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

return static function (ContainerConfigurator $container): void {
    $container
        ->parameters()
        ->set('configDir', __DIR__);

    $services = $container->services();
    $services->defaults()
        ->autoconfigure()
        ->autowire()
        ->bind('string $configDir', param('configDir'));

    $services
        ->load('App\\', '../src/*')
        ->exclude('../src/{Handler,Entity,Tests,Application.php}');

    $services
        ->load('App\\Handler\\', '../src/Handler/*')
        ->public();

    $services->alias(ContainerInterface::class, 'service_container');

    $services->set(Psr17Factory::class);

    $services
        ->set(MiddlewareInterface::class)
        ->public()
        ->factory([service(MiddlewareFactory::class), 'build']);

    $services
        ->set(ServerRequestInterface::class)
        ->public()
        ->factory([service(ServerRequestFactory::class), 'build']);

    $services
        ->set(RequestHandlerInterface::class)
        ->factory([service(RequestHandlerFactory::class), 'build']);
};
