<?php

namespace Xillion\Core\AttributeType;

class AttributeListType
{
    protected $id;

    public function __construct(AttributeType $type)
    {
        $this->type = $type;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function validate($value): void
    {
        foreach ($value as $value2) {
            $this->
        }
        return;
    }
}
