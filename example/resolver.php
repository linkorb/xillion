<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Xillion\Core\AttributeDefinition\AttributeDefinitionRegistryLoader;
use Xillion\Core\AttributeType\AttributeTypeRegistryLoader;
use Xillion\Core\ResourceResolver\ResourceResolver;
use Xillion\Core\Validator\Validator;
use Symfony\Component\Yaml\Yaml;
use Example\Entity\User;
use Example\Entity\Project;
use Example\ResourceProvider\ProjectResourceProvider;

$yaml = file_get_contents(__DIR__ . '/config.yaml');
$config = Yaml::parse($yaml);

$typeRegistry = (new AttributeTypeRegistryLoader())->load($config['attribute-types']);

$definitionRegistry = (new AttributeDefinitionRegistryLoader($typeRegistry))->load($config['attribute-definitions']);


// Instantiate a regular plain-old PHP object
$user = new User('joe', 'Joe Johnson', 'joe@example.web', ['management', 'sales']);
$project = new Project('wd', 'World Domination', ['sales', 'support']);


// Instantiate resolver

$providers = [
    new ProjectResourceProvider(),
];

$resolver = new ResourceResolver($definitionRegistry, $providers);

// Resolve attribute collection from regular object
$resource = $resolver->resolve($user);
echo "=== USER ===\n";
foreach ($resource->getAttributes() as $attribute) {
    echo $attribute->getDefinition()->getId() . PHP_EOL;
    echo "  type: " . $attribute->getDefinition()->getType()->getId() . PHP_EOL;
    echo "  values: " . $attribute->getValuesString() . PHP_EOL;
}

$validator = new Validator();
$validator->validateResource($resource);


$resource = $resolver->resolve($project);
echo "=== PROJECT ===\n";
foreach ($resource->getAttributes() as $attribute) {
    echo $attribute->getDefinition()->getId() . PHP_EOL;
    echo "  type: " . $attribute->getDefinition()->getType()->getId() . PHP_EOL;
    echo "  values: " . $attribute->getValuesString() . PHP_EOL;
}

$validator->validateResource($resource);

