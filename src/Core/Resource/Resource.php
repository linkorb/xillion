<?php

namespace Xillion\Core\Resource;

use Xillion\Core\Attribute\AttributeInterface;
use Xillion\Core\ResourceType\ResourceType;
use Xillion\Core\Utils\ArrayUtils;

class Resource implements ResourceInterface
{
    use ResourceTrait;

    public function __construct(string $id, array $attributes, array $ResourceTypes)
    {
        ArrayUtils::validateArrayType($attributes, AttributeInterface::class);
        ArrayUtils::validateArrayType($ResourceTypes, ResourceType::class);

        $this->id = $id;
        foreach ($attributes as $attribute) {
            $this->addAttribute($attribute);
        }
        $this->ResourceTypes = $ResourceTypes;
    }
}
