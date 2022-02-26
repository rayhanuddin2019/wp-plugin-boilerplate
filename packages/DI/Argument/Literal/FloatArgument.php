<?php

declare(strict_types=1);

namespace MangoCube_Packages\DI\League\Container\Argument\Literal;

use MangoCube_Packages\DI\League\Container\Argument\LiteralArgument;

class FloatArgument extends LiteralArgument
{
    public function __construct(float $value)
    {
        parent::__construct($value, LiteralArgument::TYPE_FLOAT);
    }
}
