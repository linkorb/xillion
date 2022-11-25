<?php

namespace Xillion\Core\ResourceContext;

use Xillion\Core\Resource\ResourceInterface;
use Xillion\Core\ResourceRepository\ResourceRepositoryInterface;
use Xillion\Core\Utils\ArrayUtils;
use RuntimeException;

class ResourceContext implements ResourceContextInterface, ResourceRepositoryInterface
{
    protected $repositories = [];

    // Required by ResourceRepositoryInterface
    public function getContext(): ResourceContextInterface
    {
        return $this;
    }

    public function addRepository(ResourceRepositoryInterface $repository)
    {
        $this->repositories[] = $repository;
    }

    public function addResource(ResourceInterface $resource)
    {
        throw new RuntimeException("You can't add a resource to the context directly. Add the resource to a repository instead.");
    }

    public function getResources(): array
    {
        $resources = [];
        foreach ($this->repositories as $repository) {
            $repoResources = $repository->getResources();
            $resources = array_merge($resources, $repoResources);
        }

        usort($resources, function($b, $a) {
            return strcmp($a['core.xillion.cloud/datetime'] ?? '', $b['core.xillion.cloud/datetime'] ?? '');
        });

        return $resources;
    }

    public function hasResource(string $id): bool
    {
        foreach ($this->repositories as $repository) {
            $has = $repository->hasResource($id);
            if ($has) {
                return true;
            }
        }
        return false;
    }

    public function getResource(string $id): ?ResourceInterface
    {
        foreach ($this->repositories as $repository) {
            $has = $repository->hasResource($id);
            if ($has) {
                return $repository->getResource($id);
            }
        }
        return null;
    }

    public function getResourcesByAttribute(string $attributeId, string $value): array
    {
        $resources = [];

        foreach ($this->repositories as $repository) {
            $repoResources = $repository->getResourcesByAttribute($attributeId, $value);
            $resources = array_merge($resources, $repoResources);
        }

        usort($resources, function($b, $a) {
            return strcmp($a['core.xillion.cloud/datetime'] ?? null, $b['core.xillion.cloud/datetime'] ?? null);
        });

        return $resources;
    }

    public function getResourcesWithAttribute(string $attributeId): array
    {
        $resources = [];

        foreach ($this->repositories as $repository) {
            $repoResources = $repository->getResourcesWithAttribute($attributeId);
            $resources = array_merge($resources, $repoResources);
        }

        usort($resources, function($b, $a) {
            return strcmp($a['core.xillion.cloud/datetime'] ?? null, $b['core.xillion.cloud/datetime'] ?? null);
        });

        return $resources;
    }


}
