<?php

declare(strict_types=1);

namespace MangoCube_Packages\DI\League\Container;

use MangoCube_Packages\DI\League\Container\Definition\DefinitionInterface;
use MangoCube_Packages\DI\League\Container\Inflector\InflectorInterface;
use MangoCube_Packages\DI\League\Container\ServiceProvider\ServiceProviderInterface;
use MangoCube_Packages\Psr\Container\ContainerInterface;

interface DefinitionContainerInterface extends ContainerInterface
{
    public function add(string $id, $concrete = null): DefinitionInterface;
    public function addServiceProvider(ServiceProviderInterface $provider): self;
    public function addShared(string $id, $concrete = null): DefinitionInterface;
    public function extend(string $id): DefinitionInterface;
    public function getNew($id);
    public function inflector(string $type, callable $callback = null): InflectorInterface;
}
