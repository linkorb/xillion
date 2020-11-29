<?php

namespace Xillion\Core\DataType\Xml;

class IntegerType extends DecimalType
{
    public function validate($value): void
    {
        if (!is_int($value)) {
            throw new \RuntimeException("Invalid integer value ");
        }
    }
}

