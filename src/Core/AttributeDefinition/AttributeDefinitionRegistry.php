<?php

namespace Xillion\Core\AttributeDefinition;

use Xillion\Core\Utils\ArrayUtils;
use RuntimeException;

class AttributeDefinitionRegistry
{
    protected $definitions;

    public function __construct(array $definitions)
    {
        ArrayUtils::validateArrayType($definitions, AttributeDefinitionInterface::class);

        $this->definitions = $definitions;
    }

    public function getAttributeDefinition(string $id): AttributeDefinitionInterface
    {
        if (!$this->hasAttributeDefinition($id)) {
            throw new RuntimeException("Unregistered attribute definition id: " . $id);
        }
        return $this->definitions[$id];
    }

    public function hasAttributeDefinition(string $id): bool
    {
        return isset($this->definitions[$id]);
    }

    public function getAttributeDefinitions(): array
    {
        return $this->definitions;
    }

}
