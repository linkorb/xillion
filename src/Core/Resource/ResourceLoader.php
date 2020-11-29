<?php

namespace Xillion\Core\Resource;

use Xillion\Core\ResourceContext\ResourceContext;
use Xillion\Core\ResourceType\ResourceTypeRegistry;
use RuntimeException;

class ResourceLoader
{

    public function load(ResourceContext $context, array $config): void
    {
        foreach ($config as $resourceId=>$attributes) {
            $resource = new Resource($context, $resourceId, $attributes);
            $context->addResource($resource);
        }
    }

}
