<?php

declare(strict_types=1);

namespace MangoCube_Packages\DI\Exception;

use MangoCube_Packages\Psr\NotFoundExceptionInterface;
use InvalidArgumentException;

class NotFoundException extends InvalidArgumentException implements NotFoundExceptionInterface
{
}
