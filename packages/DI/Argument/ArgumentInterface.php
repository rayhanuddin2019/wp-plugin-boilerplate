<?php

declare(strict_types=1);

namespace MangoCube_Packages\DI\Argument;

interface ArgumentInterface
{
    /**
     * @return mixed
     */
    public function getValue();
}
