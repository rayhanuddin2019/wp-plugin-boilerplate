<?php

declare(strict_types=1);

namespace MangoCube_Packages\DI\League\Container\Inflector;

use IteratorAggregate;
use MangoCube_Packages\DI\League\Container\ContainerAwareInterface;

interface InflectorAggregateInterface extends ContainerAwareInterface, IteratorAggregate
{
    public function add(string $type, callable $callback = null): Inflector;
    public function inflect(object $object);
}
