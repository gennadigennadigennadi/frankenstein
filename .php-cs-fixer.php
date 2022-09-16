<?php

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->append([__FILE__]);

$config = new PhpCsFixer\Config();

return $config->setRules([
    '@PHP80Migration' => true,
    '@PHP80Migration:risky' => true,
    '@PSR12' => true,
    '@PSR12:risky' => true,
    'strict_param' => true,
    'array_syntax' => [
        'syntax' => 'short', ], ]
)
    ->setRiskyAllowed(true)
    ->setFinder($finder);
