<?php

namespace Xillion\Core\AttributeType\Xml;

use Xillion\Core\AttributeValue;

class IntegerType extends DecimalType
{
    public function validate($value): void
    {
        if (!is_int($value)) {
            throw new \RuntimeException("Invalid integer value ");
        }
    }
}

