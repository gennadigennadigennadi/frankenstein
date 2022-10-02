<?php

declare(strict_types=1);

use App\Application;
use App\Infrastucture\Factory\ContainerFactory;

require_once dirname(__DIR__).'/vendor/autoload.php';

(function (): void {
    $container = (require_once dirname(__DIR__).'/config/container.php')();
    $app = $container->get(Application::class);

    $app->run();
})();
