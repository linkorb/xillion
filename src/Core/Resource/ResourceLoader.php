<?php

namespace Xillion\Core\Resource;

use Xillion\Core\Attribute\Attribute;
use Xillion\Core\ResourceType\ResourceTypeRegistry;
use Xillion\Core\AttributeDefinition\AttributeDefinitionRegistry;
use RuntimeException;

class ResourceLoader
{
    protected $definitionRegistry;

    public function __construct(AttributeDefinitionRegistry $definitionRegistry, ResourceTypeRegistry $resourceTypeRegistry)
    {
        $this->definitionRegistry = $definitionRegistry;
        $this->resourceTypeRegistry = $resourceTypeRegistry;
    }

    public function load(array $config): array
    {
        $resources = [];
        $resourceTypes = [];
        foreach ($config as $resourceId=>$resourceConfig) {
            $attributes = [];
            $resourceTypes = [];
            foreach ($resourceConfig['types'] as $resourceTypeId) {
                $resourceType = $this->resourceTypeRegistry->getResourceType($resourceTypeId);
                $resourceTypes[] = $resourceType;
            }

            foreach ($resourceConfig['attributes'] as $attributeDefinitionId => $attributeValues) {
                if (!is_array($attributeValues)) {
                    $attributeValues = [$attributeValues];
                }
                $attributeDefinition = $this->definitionRegistry->getAttributeDefinition($attributeDefinitionId);
                $attribute = new Attribute($attributeDefinition, $attributeValues);
                $attributes[] = $attribute;
            }
            $resource = new Resource($resourceId, $attributes, $resourceTypes);
            $resources[] = $resource;
        }

        return $resources;
    }

}
