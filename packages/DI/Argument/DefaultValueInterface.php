<?php

declare(strict_types=1);

namespace MangoCube_Packages\DI\Argument;

interface DefaultValueInterface extends ArgumentInterface
{
    /**
     * @return mixed
     */
    public function getDefaultValue();
}
