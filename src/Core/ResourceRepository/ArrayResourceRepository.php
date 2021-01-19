<?php

namespace Xillion\Core\ResourceRepository;

use Xillion\Core\ResourceContext\ResourceContextInterface;
use Xillion\Core\Resource\ResourceInterface;
use RuntimeException;

class ArrayResourceRepository implements ResourceRepositoryInterface
{
    protected $resources = [];
    protected $context;

    public function __construct(ResourceContextInterface $context)
    {
        $this->context = $context;
    }

    public function getContext(): ResourceContextInterface
    {
        return $this->context;
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
