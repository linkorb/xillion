<?php

namespace Xillion\Core\Resource;

use Xillion\Core\ResourceRepository\ResourceRepositoryInterface;
use RuntimeException;

class ResourceLoader
{

    public function load(ResourceRepositoryInterface $repository, array $config): void
    {
        foreach ($config as $resourceId=>$attributes) {
            $resource = new Resource($repository, $resourceId, $attributes);
            $repository->addResource($resource);
        }
    }

}
