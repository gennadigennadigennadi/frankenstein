<?php

declare(strict_types=1);

namespace App\Domain\Generator;

interface StringGenerator
{
    public function generate(): string;
}
