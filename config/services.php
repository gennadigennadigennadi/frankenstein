<?php

declare(strict_types=1);

use App\Application;
use App\Infrastructure\Factory\MiddlewareFactory;
use App\Infrastructure\Factory\RequestHandlerFactory;
use App\Infrastructure\Factory\ServerRequestFactory;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

use function Symfony\Component\DependencyInjection\Loader\Configurator\param;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $container): void {
    $container
        ->parameters()
        ->set('rootDir', dirname(__DIR__))
        ->set('configDir', param('rootDir') . '/config/')
        ->set('cacheDir', param('rootDir') . '/var/');

    $services = $container->services();
    $services->defaults()
        ->autoconfigure()
        ->autowire()
        ->bind('string $configDir', param('configDir'));

    $services->load('App\\', '../src/*');

    $services
        ->load('App\\Infrastructure\\Handler\\', '../src/Infrastructure/Handler/*')
        ->public();

    $services->alias(ContainerInterface::class, 'service_container');
    $services->set(Application::class)->public();
    $services->set(Psr17Factory::class);

    $services
        ->set(MiddlewareInterface::class)
        ->factory([service(MiddlewareFactory::class), 'build']);

    $services
        ->set(ServerRequestInterface::class)
        ->factory([service(ServerRequestFactory::class), 'build']);

    $services
        ->set(RequestHandlerInterface::class)
        ->factory([service(RequestHandlerFactory::class), 'build']);
};
