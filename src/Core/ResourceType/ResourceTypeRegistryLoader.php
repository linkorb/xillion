<?php

namespace Xillion\Core\ResourceType;

use Xillion\Core\AttributeDefinition\AttributeDefinitionRegistry;
use RuntimeException;

class ResourceTypeRegistryLoader
{
    protected $definitionRegistry;

    public function __construct(AttributeDefinitionRegistry $definitionRegistry)
    {
        $this->definitionRegistry = $definitionRegistry;
    }

    public function load(array $config): ResourceTypeRegistry
    {
        $resourceTypes = [];
        foreach ($config as $resourceTypeId=>$resourceTypeConfig) {
            $definitions = [];
            foreach ($resourceTypeConfig['attribute-definitions'] as $definitionId) {
                $definition = $this->definitionRegistry->getAttributeDefinition($definitionId);
                $definitions[] = $definition;
            }
            $resourceType = new ResourceType($definitions);
            $resourceTypes[$resourceTypeId] = $resourceType;
        }

        $registry = new ResourceTypeRegistry($resourceTypes);
        return $registry;
    }

}
