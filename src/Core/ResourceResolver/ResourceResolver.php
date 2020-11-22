<?php

namespace Xillion\Core\ResourceResolver;

use Xillion\Core\Attribute\Attribute;
use Xillion\Core\ResourceResolver\ResourceConfigInterface;
use Xillion\Core\Resource\Resource;
use Xillion\Core\Resource\ResourceInterface;
use Xillion\Core\AttributeDefinition\AttributeDefinitionRegistry;
use RuntimeException;

class ResourceResolver
{
    protected $definitionRegistry;
    protected $providers;

    public function __construct(AttributeDefinitionRegistry $definitionRegistry, array $providers)
    {
        $this->definitionRegistry = $definitionRegistry;
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

    public function toResource(array $config): ResourceInterface
    {
        $attributes = [];

        foreach ($config['attributes'] as $k=>$values) {
            $definition = $this->definitionRegistry->getAttributeDefinition($k);
            if (!is_array($values)) {
                $values = [$values];
            }

            $attributeValues = [];
            foreach ($values as $value) {
                $attributeValues[] = $value;
            }
            $attributes[] = new Attribute($definition, $attributeValues);
        }

        $types = [];
        $id = $config['id'];
        $resource = new Resource($id, $attributes, $types);

        return $resource;
    }
}
