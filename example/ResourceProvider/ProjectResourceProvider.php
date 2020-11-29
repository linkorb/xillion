<?php

namespace Example\ResourceProvider;

use Xillion\Core\ResourceResolver\ResourceConfigProviderInterface;
use Example\Entity\Project;

class ProjectResourceProvider implements ResourceConfigProviderInterface
{
    public function supports($obj): bool
    {
        if ($obj instanceof Project) {
            return true;
        }
        return false;
    }

    public function getResourceConfig($obj): array
    {
        return [
            '$id' => $obj->getId(),
            'urn:oasis:names:tc:xacml:1.0:resource:resource-id' => $obj->getId(),
            'https://example.linkorb.com/xillion/attributes/user-groups' => $obj->getGroupNames(),
        ];
    }
}
