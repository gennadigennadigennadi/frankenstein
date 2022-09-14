<?php

namespace App\Factory;

use Psr\Container\ContainerInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

final class ContainerFactory
{
    public function __construct(
        private string $configDir = __DIR__ . '/../../config/',
    ) {
    }

    public function build(): ContainerInterface
    {
        $containerBuilder = new ContainerBuilder();
        $phpFileloader = new PhpFileLoader($containerBuilder, new FileLocator($this->configDir));
        $phpFileloader->load('services.php');

        $containerBuilder->compile();

        return $containerBuilder;
    }
}
