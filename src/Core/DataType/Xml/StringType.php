<?php

namespace Xillion\Core\DataType\Xml;

class StringType extends AnyType
{
    public function validate($value): void
    {
        if (!is_string($value)) {
            throw new \RuntimeException("Invalid string value: " . json_encode($value));
        }
    }
}

