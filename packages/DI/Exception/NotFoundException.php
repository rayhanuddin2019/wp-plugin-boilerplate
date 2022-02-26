<?php

declare(strict_types=1);

namespace MangoCube_Packages\DI\League\Container\Exception;

use MangoCube_Packages\Psr\Container\NotFoundExceptionInterface;
use InvalidArgumentException;

class NotFoundException extends InvalidArgumentException implements NotFoundExceptionInterface
{
}
