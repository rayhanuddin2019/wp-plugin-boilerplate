<?php

declare(strict_types=1);

namespace MangoCube_Packages\DI\League\Container\ServiceProvider;

use MangoCube_Packages\DI\League\Container\ContainerAwareInterface;

interface ServiceProviderInterface extends ContainerAwareInterface
{
    public function getIdentifier(): string;
    public function provides(string $id): bool;
    public function register(): void;
    public function setIdentifier(string $id): ServiceProviderInterface;
}
