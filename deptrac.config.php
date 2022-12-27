<?php

declare(strict_types=1);

use Qossmic\Deptrac\Contract\Config\Collector\DirectoryConfig;
use Qossmic\Deptrac\Contract\Config\DeptracConfig;
use Qossmic\Deptrac\Contract\Config\EmitterType;
use Qossmic\Deptrac\Contract\Config\Layer;
use Qossmic\Deptrac\Contract\Config\RulesetConfig;

return static function (DeptracConfig $config): void {
    $application = Layer::withName('app')->collectors(
        DirectoryConfig::public('src/Application/.*')
    );
    $domain = Layer::withName('domain')->collectors(
        DirectoryConfig::public('src/Domain/.*')
    );
    $infrastructure = Layer::withName('infrastructure')->collectors(
        DirectoryConfig::public('src/Infrastructure/.*')
    );

    $config
        ->analysers(
            EmitterType::CLASS_TOKEN,
            EmitterType::USE_TOKEN,
        )
        ->layers($application, $domain, $infrastructure)
        ->rulesets(
            RulesetConfig::layer($infrastructure)->accesses($application, $domain),
            RulesetConfig::layer($application)->accesses($domain),
            RulesetConfig::layer($domain),
        );
};
