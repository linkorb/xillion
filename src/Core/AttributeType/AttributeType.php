<?php

namespace Xillion\Core\AttributeType;

use Xillion\Core\AttributeValue;

class AttributeType
{
    protected $id;

    public function __construct(string $typeId)
    {
        $this->id = $typeId;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function validate($value): void
    {
        return;
    }
}
