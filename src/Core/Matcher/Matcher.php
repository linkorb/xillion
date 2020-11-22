<?php

namespace Xillion\Core\Matcher;

use Xillion\Core\AttributeInterface;
use Xillion\Core\Resource\ResourceInterface;
use Xillion\Core\ResourceContext\ResourceContextInterface;

class Matcher
{

    public function matchResourceAttributes(ResourceInterface $resource, $criteria): bool {
        $match = true;
        foreach ($criteria as $attributeId => $v) {
            if (!$resource->hasAttribute($attributeId)) {
                $match = false;
            } else {
                $a = $resource->getAttribute($attributeId);
                foreach ($a->getValues() as $v2) {
                    if ($v==$v2) {
                        return true;
                    }
                }
            }
        }
        return $match;
    }

    public function findResourcesInContext(ResourceContextInterface $context, $criteria): array
    {
        $res = [];
        foreach ($context->getResources() as $resource) {
            if ($this->matchResourceAttributes($resource, $criteria)) {
                $res[] = $resource;
            }
        }
        return $res;
    }

}
