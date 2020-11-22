<?php

namespace Xillion\Core\AttributeType;

use RuntimeException;

class AttributeTypeRegistryLoader
{
    public function load(array $config): AttributeTypeRegistry
    {
        $types = [];
        foreach ($config as $typeId=>$typeConfig) {
            $className = $typeConfig['class'];
            $type = new $className($typeId);
            $types[$typeId] = $type;
        }

        $registry = new AttributeTypeRegistry($types);
        return $registry;
    }

}
