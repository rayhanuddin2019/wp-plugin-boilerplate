<?php

declare(strict_types=1);

namespace MangoCube_Packages\DI\Argument;

use MangoCube_Packages\DI\ContainerAwareInterface;
use ReflectionFunctionAbstract;

interface ArgumentResolverInterface extends ContainerAwareInterface
{
    public function resolveArguments(array $arguments): array;
    public function reflectArguments(ReflectionFunctionAbstract $method, array $args = []): array;
}
