<?php

declare(strict_types=1);

namespace App\Domain\Generator;

final class HelloGenerator implements StringGenerator
{
    public function generate(): string
    {
        return 'hello';
    }
}
