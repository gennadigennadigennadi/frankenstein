<?php

declare(strict_types=1);

use App\Infrastucture\Factory\ContainerFactory;
use Psr\Container\ContainerInterface;

return static function (): ContainerInterface {
    $rootDir = dirname(__DIR__);
    $cacheDir = $rootDir.DIRECTORY_SEPARATOR.'var';
    $configDir = $rootDir.DIRECTORY_SEPARATOR.'config';

    return (new ContainerFactory(configDir: $configDir, cacheDir: $cacheDir))->build();
};
