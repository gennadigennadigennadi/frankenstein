<?php

declare(strict_types=1);

namespace App\Factory;

use Psr\Container\ContainerInterface;
use Symfony\Component\Config\ConfigCache;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

final class ContainerFactory
{
    public function __construct(
        private string $configDir = __DIR__.'/../../config/',
        private string $cacheDir = __DIR__.'/../../var/container.php',
    ) {
    }

    public function build(): ContainerInterface
    {
        $containerConfigCache = new ConfigCache($this->cacheDir, true);

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

        require_once $this->cacheDir;

        return new \MyCachedContainer();
    }
}
