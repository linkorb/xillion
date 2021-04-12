<?php

namespace Xillion\Core\Resource;

use ArrayAccess;
use Xillion\Core\ResourceContext\ResourceContext;
use Xillion\Core\ResourceRepository\ResourceRepositoryInterface;

class Resource implements ResourceInterface, ArrayAccess
{
    protected $context;

    public function __construct(ResourceRepositoryInterface $repository, string $id, array $attributes)
    {
        $this->repository = $repository;
        $this->context = $this->repository->getContext();
        $this->id = $id;
        $this->attributes = $attributes;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getHash(): string
    {
        return sha1($this->id);
    }

    protected function addAttribute(string $key, $value): void
    {
        $this->attributes[$key] = $value;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }



    public function is(string $key, $value): bool
    {
        if (!$this->hasAttribute($key)) {
            return false;
        }
        $attributeResource = $this->context->getResource($key);

        $v = $this->getAttribute($key);

        if ($attributeResource->getAttribute('core.xillion.cloud/is-array')) {
            foreach ($v as $v2) {
                if ($value==$v2) {
                    return true;
                }
            }
        } else {
            if ($value==$v) {
                return true;
            }
        }
        return false;

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

    public function toArray(): array
    {
        return [
            $this->getId() => $this->getAttributes()
        ];
    }

    public function resolve(string $key)
    {
        // echo "Getting attribute $key\n";
        $value = $this->getAttribute($key);
        if (!$value) {
            return null;
        }
        $attributeResource = $this->context->getResource($key);

        if ($this->id!='core.xillion.cloud/data-type') {
            if ($attributeResource->getAttribute('core.xillion.cloud/data-type') == 'core.xillion.cloud/data-types/resource') {
                if ($attributeResource->getAttribute('core.xillion.cloud/is-array')) {
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
        $this->attributes[$offset] = $value;
    }

    public function offsetUnset($offset): void
    {
        unset($this->attributes[$offset]);
    }
}
