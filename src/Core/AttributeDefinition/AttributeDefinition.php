<?php

namespace Xillion\Core\AttributeDefinition;

use Xillion\Core\AttributeType\AttributeType;

class AttributeDefinition implements AttributeDefinitionInterface
{
    protected $id;
    protected $type;

    public function __construct(string $id, AttributeType $type)
    {
        $this->id = $id;
        $this->type = $type;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getType()
    {
        return $this->type;
    }
}
