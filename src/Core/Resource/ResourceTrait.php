<?php

namespace Xillion\Core\Resource;

use Xillion\Core\Definition\AttributeDefinition;
use Xillion\Core\Attribute\AttributeInterface;


trait ResourceTrait
{
    protected $id;
    protected $attributes = [];
    protected $ResourceTypes = [];

    protected function addAttribute(AttributeInterface $attribute): void
    {
        $this->attributes[$attribute->getDefinition()->getId()] = $attribute;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function hasAttribute(string $id): bool
    {
        return isset($this->attributes[$id]);
    }

    public function getAttribute(string $id): AttributeInterface
    {
        if (!$this->hasAttribute($id)) {
            throw new RuntimeException("No such attribute: " . $id);
        }
        return $this->attributes[$id];
    }

    public function getResourceTypes(): array
    {
        return $this->ResourceTypes;
    }
}
