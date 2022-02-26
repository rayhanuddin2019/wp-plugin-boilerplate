<?php

declare(strict_types=1);

namespace MangoCube_Packages\DI\Argument\Literal;

use MangoCube_Packages\DI\Argument\LiteralArgument;

class ObjectArgument extends LiteralArgument
{
    public function __construct(object $value)
    {
        parent::__construct($value, LiteralArgument::TYPE_OBJECT);
    }
}
