<?php

namespace Xillion\Core\Resource;

use Xillion\Core\Definition\AttributeDefinition;
use Xillion\Core\Attribute\AttributeInterface;

interface ResourceInterface
{
    public function getAttributes(): array;
    public function hasAttribute(string $id): bool;
    public function getAttribute(string $id): AttributeInterface;
    public function getResourceTypes(): array;
}
