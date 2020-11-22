<?php

namespace Xillion\Core\Attribute;

use Xillion\Core\AttributeDefinition\AttributeDefinitionInterface;

class Attribute implements AttributeInterface
{
    protected $definition;
    protected $values;

    public function __construct(AttributeDefinitionInterface $definition, array $values)
    {
        $this->definition = $definition;
        $this->values = $values;
    }

    public function getDefinition(): AttributeDefinitionInterface
    {
        return $this->definition;
    }

    public function getValues(): array
    {
        return $this->values;
    }

    public function getValuesString(): string
    {
        $strings = [];
        foreach ($this->values as $value) {
            $strings[] = $value;
        }
        return json_encode($strings, JSON_UNESCAPED_SLASHES);
    }

}
