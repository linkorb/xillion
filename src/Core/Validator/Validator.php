<?php

namespace Xillion\Core\Validator;

use Xillion\Core\Attribute\AttributeInterface;
use Xillion\Core\Resource\ResourceInterface;
use Xillion\Core\ResourceContext\ResourceContextInterface;

class Validator
{
    protected $attributes = [];

    public function validateAttribute(AttributeInterface $attribute): bool
    {
        $definition = $attribute->getDefinition();
        $type = $definition->getType();
        foreach ($attribute->getValues() as $value) {
            $type->validate($value);
        }
        return true;
    }

    public function validateResource(ResourceInterface $Resource): bool
    {
        foreach ($Resource->getAttributes() as $attribute) {
            $this->validateAttribute($attribute);
        }

        foreach ($Resource->getResourceTypes() as $ResourceType) {
            $ResourceType->validate($Resource);
        }
        return true;
    }

    public function validateResourceContext(ResourceContextInterface $context): bool
    {
        foreach ($context->getResources() as $Resource) {
            $this->validateResource($Resource);
        }
        return true;
    }
}
