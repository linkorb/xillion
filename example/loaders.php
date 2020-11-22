<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Xillion\Core\Attribute;
use Xillion\Core\Resource\ResourceLoader;
use Xillion\Core\ResourceContext\ResourceContext;
use Xillion\Core\ResourceType\ResourceTypeRegistryLoader;
use Xillion\Core\AttributeDefinition\AttributeDefinition;
use Xillion\Core\AttributeDefinition\AttributeDefinitionRegistry;
use Xillion\Core\AttributeDefinition\AttributeDefinitionRegistryLoader;
use Xillion\Core\Validator\Validator;
use Xillion\Core\AttributeType\AttributeType;
use Xillion\Core\AttributeType\AttributeTypeRegistryLoader;
use Xillion\Core\Resolver\AttributeResolver;

use Symfony\Component\Yaml\Yaml;
use Example\User;

$yaml = file_get_contents(__DIR__ . '/config.yaml');
$config = Yaml::parse($yaml);

$typeRegistry = (new AttributeTypeRegistryLoader())->load($config['attribute-types']);

$definitionRegistry = (new AttributeDefinitionRegistryLoader($typeRegistry))->load($config['attribute-definitions']);

print_r($definitionRegistry);

$resourceTypeRegistry = (new ResourceTypeRegistryLoader($definitionRegistry))->load($config['resource-types']);

$resources = (new ResourceLoader($definitionRegistry, $resourceTypeRegistry))->load($config['resources']);

print_r($resources);

$context = new ResourceContext($resources);

$validator = new Validator();
$validator->validateResourceContext($context);
