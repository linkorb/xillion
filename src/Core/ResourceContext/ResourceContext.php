<?php

namespace Xillion\Core\ResourceContext;

use Xillion\Core\Resource\ResourceInterface;
use Xillion\Core\Utils\ArrayUtils;

class ResourceContext implements ResourceContextInterface
{
    protected $Resources = [];

    public function __construct(array $Resources)
    {
        ArrayUtils::validateArrayType($Resources, ResourceInterface::class);

        $this->Resources = $Resources;
    }

    public function getResources(): array
    {
        return $this->Resources;
    }
}
