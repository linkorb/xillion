<?php

namespace Xillion\Core\DataType;

class DataType
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
