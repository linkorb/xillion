<?php

namespace Xillion\Core\AttributeDefinition;

use Xillion\Core\AttributeType\AttributeTypeRegistry;
use RuntimeException;

class AttributeDefinitionRegistryLoader
{
    protected $typeRegistry;

    public function __construct(AttributeTypeRegistry $typeRegistry)
    {
        $this->typeRegistry = $typeRegistry;
    }

    public function load(array $config): AttributeDefinitionRegistry
    {
        $definitions = [];
        foreach ($config as $definitionId=>$definitionConfig) {
            $typeId = $definitionConfig['type'] ?? null;
            $type = $this->typeRegistry->get($typeId);
            $definition = new AttributeDefinition($definitionId, $type);
            $definitions[$definitionId] = $definition;
        }

        $registry = new AttributeDefinitionRegistry($definitions);
        return $registry;
    }

}
