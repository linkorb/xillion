<?php

namespace Xillion\Core\ResourceResolver;

interface ResourceConfigProviderInterface
{
    public function supports($obj): bool;
    public function getResourceConfig($obj): array;
}
