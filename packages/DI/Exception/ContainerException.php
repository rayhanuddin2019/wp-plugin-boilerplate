<?php

declare(strict_types=1);

namespace MangoCube_Packages\DI\Exception;

use MangoCube_Packages\Psr\ContainerExceptionInterface;
use RuntimeException;

class ContainerException extends RuntimeException implements ContainerExceptionInterface
{
}
