<?php

namespace Xillion\Core\ResourceResolver;

use Xillion\Core\ResourceResolver\ResourceConfigInterface;
use Xillion\Core\Resource\Resource;
use Xillion\Core\Resource\ResourceInterface;
use Xillion\Core\ResourceContext\ResourceContextInterface;
use RuntimeException;

class ResourceResolver
{
    protected $context;
    protected $providers;

    public function __construct(ResourceContextInterface $context, array $providers)
    {
        $this->context = $context;
        $this->providers = $providers;
    }

    public function resolve(object $obj): ResourceInterface
    {
        if ($obj instanceof ResourceConfigInterface) {
            $config = $obj->getResourceConfig();
            return $this->toResource($config);
        }

        foreach ($this->providers as $provider) {
            if ($provider->supports($obj)) {
                $config = $provider->getResourceConfig($obj);
                return $this->toResource($config);
            }
        }

        throw new RuntimeException("Unable to resolve attributes for " . get_class($obj));
    }

    public function toResource(array $attributes): ResourceInterface
    {
        $id = $attributes['$id'] ?? null;
        if ($id) {
            unset($attributes['$id']);
        } else {
            throw new RuntimeException("Missing required \$id attribute");
        }
        $resource = new Resource($this->context, $id, $attributes);
        return $resource;
    }
}
