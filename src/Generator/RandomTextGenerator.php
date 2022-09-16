<?php

declare(strict_types=1);

namespace App\Generator;

use App\Generator\StringGenerator;

final class RandomTextGenerator implements StringGenerator
{
    public function generate(): string
    {
        $result = sha1(random_bytes(123124));

        return 'RandomText: ' . $result;
    }
}
