<?php

namespace Xillion\Core\ResourceContext;

use Xillion\Core\Resource\ResourceInterface;
use Xillion\Core\Utils\ArrayUtils;
use RuntimeException;

class ResourceContext implements ResourceContextInterface
{
    protected $resources = [];

    public function __construct()
    {
    }

    public function addResource(ResourceInterface $resource)
    {
        $this->resources[$resource->getId()] = $resource;
    }

    public function getResources(): array
    {
        return $this->resources;
    }

    public function hasResource(string $id): bool
    {
        return isset($this->resources[$id]);
    }

    public function getResource(string $id): ?ResourceInterface
    {
        if (!$this->hasResource($id)) {
            return null;
        }
        return $this->resources[$id];
    }

    public function getResourcesByAttribute(string $attributeId, string $value): array
    {
        $resources = [];
        foreach ($this->resources as $resource) {
            if ($resource->hasAttribute($attributeId)) {
                $values = $resource->getAttribute($attributeId);
                if (!is_array($values)) {
                    $values = [$values];
                }
                foreach ($values as $v) {
                    if ($v==$value) {
                        $resources[$resource->getId()] = $resource;
                    }
                }
            }
        }
        return $resources;
    }
}
