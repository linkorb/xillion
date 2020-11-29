<?php

namespace Xillion\Core\Resource;

use ArrayAccess;
use Xillion\Core\ResourceContext\ResourceContext;

class Resource implements ResourceInterface, ArrayAccess
{
    protected $context;

    public function __construct(ResourceContext $context, string $id, array $attributes)
    {
        $this->context = $context;
        $this->id = $id;
        $this->attributes = $attributes;
    }

    public function getId(): string
    {
        return $this->id;
    }

    protected function addAttribute(string $key, $v): void
    {
        $this->attributes[$key] = $v;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function hasAttribute(string $key): bool
    {
        return isset($this->attributes[$key]);
    }

    public function getAttribute(string $key)
    {
        if (!$this->hasAttribute($key)) {
            return null;
        }
        return $this->attributes[$key];
    }

    public function resolve(string $key)
    {
        // echo "Getting attribute $key\n";
        $value = $this->getAttribute($key);
        $attributeResource = $this->context->getResource($key);

        if ($this->id!='https://core.xillion.cloud/xillion/attributes/data-type') {
            if ($attributeResource->getAttribute('https://core.xillion.cloud/xillion/attributes/data-type') == 'https://core.xillion.cloud/xillion/data-types/resource') {
                if ($attributeResource->getAttribute('https://core.xillion.cloud/xillion/attributes/is-array')) {
                    $resources = [];
                    foreach ($value as $v) {
                        $resources[] = $this->context->getResource($v);
                    }
                    return $resources;
                }
                $value = $this->context->getResource($value);
            }
        }
        return $value;
    }

    public function offsetExists($offset): bool
    {
        return $this->hasAttribute($offset);
    }

    public function offsetGet($offset)
    {
        return $this->getAttribute($offset);
    }

    public function offsetSet($offset, $value): void
    {
        throw new RuntimeException("Attribute setting not yet implemented");
    }

    public function offsetUnset($offset): void
    {
        throw new RuntimeException("Attribute clearing not yet implemented");
    }
}
