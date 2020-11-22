<?php

namespace Xillion\Core\ResourceType;

use Xillion\Core\Utils\ArrayUtils;
use RuntimeException;

class ResourceTypeRegistry
{
    protected $resourceTypes;

    public function __construct(array $resourceTypes)
    {
        ArrayUtils::validateArrayType($resourceTypes, ResourceType::class);

        $this->resourceTypes = $resourceTypes;
    }

    public function getResourceType(string $id): ResourceType
    {
        if (!$this->hasResourceType($id)) {
            throw new RuntimeException("Unregistered attribute resource type id: " . $id);
        }
        return $this->resourceTypes[$id];
    }

    public function hasResourceType(string $id): bool
    {
        return isset($this->resourceTypes[$id]);
    }

    public function getResourceTypes(): array
    {
        return $this->resourceTypes;
    }

}
