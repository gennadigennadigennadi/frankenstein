<?php

declare(strict_types=1);

namespace App\Generator;

final class HelloGenerator implements StringGenerator
{
    public function generate(): string
    {
        return 'hello';
    }
}
