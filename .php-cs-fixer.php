<?php

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->in(['.'])
    ->exclude(['var']);

$config = new PhpCsFixer\Config();

return $config
    ->setRiskyAllowed(true)
    ->setFinder($finder)
    ->setRules([
        '@PHP80Migration' => true,
        '@PHP80Migration:risky' => true,
        '@PSR12' => true,
        '@PSR12:risky' => true,
        '@Symfony' => true,
        'strict_param' => true,
        'array_syntax' => [ 'syntax' => 'short', ], 
    ]);
