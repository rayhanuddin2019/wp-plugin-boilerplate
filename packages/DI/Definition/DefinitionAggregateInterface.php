<?php

declare(strict_types=1);

namespace MangoCube_Packages\DI\Definition;

use IteratorAggregate;
use MangoCube_Packages\DI\ContainerAwareInterface;

interface DefinitionAggregateInterface extends ContainerAwareInterface, IteratorAggregate
{
    public function add(string $id, $definition): DefinitionInterface;
    public function addShared(string $id, $definition): DefinitionInterface;
    public function getDefinition(string $id): DefinitionInterface;
    public function has(string $id): bool;
    public function hasTag(string $tag): bool;
    public function resolve(string $id);
    public function resolveNew(string $id);
    public function resolveTagged(string $tag): array;
    public function resolveTaggedNew(string $tag): array;
}
