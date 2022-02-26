<?php

declare(strict_types=1);

namespace MangoCube_Packages\DI\League\Container\Argument\Literal;

use MangoCube_Packages\DI\League\Container\Argument\LiteralArgument;

class CallableArgument extends LiteralArgument
{
    public function __construct(callable $value)
    {
        parent::__construct($value, LiteralArgument::TYPE_CALLABLE);
    }
}
