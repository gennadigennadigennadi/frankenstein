<?php

declare(strict_types=1);

use App\Application;
use App\Infrastructure\Factory\ContainerFactory;

require_once dirname(__DIR__) . '/vendor/autoload.php';

(function (): void {
    $container = (new ContainerFactory(
        configDir: '../config',
        cacheDir: '../cache',
    ))->build();

    $app = $container->get(Application::class);

    $app->run();
})();
