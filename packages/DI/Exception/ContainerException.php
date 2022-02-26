<?php

declare(strict_types=1);

namespace MangoCube_Packages\DI\League\Container\Exception;

use MangoCube_Packages\Psr\Container\ContainerExceptionInterface;
use RuntimeException;

class ContainerException extends RuntimeException implements ContainerExceptionInterface
{
}
