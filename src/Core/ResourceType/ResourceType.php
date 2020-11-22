<?php

namespace Xillion\Core\ResourceType;

use Xillion\Core\Resource\ResourceInterface;
use Xillion\Core\AttributeDefinition\AttributeDefinitionInterface;
use Xillion\Core\Utils\ArrayUtils;
use RuntimeException;

class ResourceType
{
    protected $attributeDefinitions = [];

    public function __construct(array $attributeDefinitions)
    {
        ArrayUtils::validateArrayType($attributeDefinitions, AttributeDefinitionInterface::class);

        $this->attributeDefinitions = $attributeDefinitions;
    }

    public function getAttributeDefinitions(): array
    {
        return $this->attributeDefinitions;
    }

    public function validate(ResourceInterface $resource): void
    {
        foreach ($this->attributeDefinitions as $attributeDefinition) {
            $id = $attributeDefinition->getId();
            if (!$resource->hasAttribute($id)) {
                throw new RuntimeException('Resource validation error. Missing attribute ' . $id);
            }
        }
    }
}
