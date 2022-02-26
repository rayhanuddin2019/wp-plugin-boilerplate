<?php

declare(strict_types=1);

namespace MangoCube_Packages\DI\League\Container\Argument;

use MangoCube_Packages\DI\League\Container\ContainerAwareInterface;
use ReflectionFunctionAbstract;

interface ArgumentResolverInterface extends ContainerAwareInterface
{
    public function resolveArguments(array $arguments): array;
    public function reflectArguments(ReflectionFunctionAbstract $method, array $args = []): array;
}
