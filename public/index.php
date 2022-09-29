<?php

declare(strict_types=1);

use App\Application;
use App\Factory\ContainerFactory;

require_once __DIR__.'/../vendor/autoload.php';

$container = (new ContainerFactory())->build();

$app = $container->get(Application::class);
$app->run();
