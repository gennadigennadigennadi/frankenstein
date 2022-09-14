<?php

namespace App\Generator;

final class SayHelloGenerator implements StringGenerator
{
    public function generate(): string
    {
        return 'hello';
    }
}
