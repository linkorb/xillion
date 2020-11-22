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
            'id' => $obj->getId(),
            'attributes' => [
                'urn:oasis:names:tc:xacml:1.0:resource:resource-id' => $obj->getId(),
                'http://linkorb.com/attributes/group' => $obj->getGroupNames(),
            ],
            'types' => [

            ],
        ];
    }
}
