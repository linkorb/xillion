<?php

namespace Xillion\Core\Utils;

use DomainException;

class ArrayUtils
{
    public static function validateArrayType(array $items, string $typeName): void
    {
        foreach ($items as $item) {
            if (!is_a($item, $typeName, false)) {
                throw new DomainException("Item in array not of expected type " . $typeName);
            }
        }
    }
}
