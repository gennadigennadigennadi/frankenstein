<?php

declare(strict_types=1);

namespace App\Infrastructure\Factory;

use Psr\Container\ContainerInterface;
use Symfony\Component\Config\ConfigCache;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

final class ContainerFactory
{
    private const COMPILED_CONTAINER = 'container.php';

    public function __construct(
        private readonly string $configDir,
        private readonly string $cacheDir,
    ) {
    }

    public function build(): ContainerInterface
    {
        $containerConfigCache = new ConfigCache($this->cacheDir . DIRECTORY_SEPARATOR . self::COMPILED_CONTAINER, true);

        if (!$containerConfigCache->isFresh()) {
            $containerBuilder = new ContainerBuilder();
            $phpFileloader = new PhpFileLoader($containerBuilder, new FileLocator($this->configDir));
            $phpFileloader->load('services.php');
            $containerBuilder->compile();

            $dumper = new PhpDumper($containerBuilder);
            $containerConfigCache->write(
                $dumper->dump(['class' => 'MyCachedContainer']),
                $containerBuilder->getResources()
            );
        }

        require_once $this->cacheDir . DIRECTORY_SEPARATOR . self::COMPILED_CONTAINER;

        return new \MyCachedContainer();
    }
}
