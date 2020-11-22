<?php

namespace Xillion\Core\Attribute;

use Xillion\Core\AttributeDefinition\AttributeDefinitionInterface;

interface AttributeInterface
{
    public function getDefinition(): AttributeDefinitionInterface;
    public function getValues(): array;
    public function getValuesString(): string;
}
