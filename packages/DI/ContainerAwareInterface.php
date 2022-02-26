<?php

declare(strict_types=1);

namespace MangoCube_Packages\DI\League\Container;

interface ContainerAwareInterface
{
    public function getContainer(): DefinitionContainerInterface;
    public function setContainer(DefinitionContainerInterface $container): ContainerAwareInterface;
}
