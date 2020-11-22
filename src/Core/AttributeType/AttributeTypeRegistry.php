<?php

namespace Xillion\Core\AttributeType;

use RuntimeException;

class AttributeTypeRegistry
{
    protected $types;

    public function __construct(array $types)
    {
        $this->types = $types;
    }

    public function get(string $id): AttributeType
    {
        if (!$this->has($id)) {
            throw new RuntimeException("Unregistered type id: " . $id);
        }
        return $this->types[$id];
    }

    public function has(string $id): bool
    {
        return isset($this->types[$id]);
    }

    public function all(): array
    {
        return $this->types;
    }

}
