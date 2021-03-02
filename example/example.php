<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Xillion\Core\Attribute;
use Xillion\Core\Resource\ResourceLoader;
use Xillion\Core\ResourceContext\ResourceContext;
use Xillion\Core\Validator\Validator;
use Xillion\Core\ResourceResolver\ResourceResolver;
use Xillion\Core\ResourceRepository\ArrayResourceRepository;
use Example\Entity\User;
use Example\Entity\Project;
use Example\ResourceProvider\ProjectResourceProvider;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Psr16Cache;

use Symfony\Component\Yaml\Yaml;

$context = new ResourceContext();
// $context = new ChainRepository();
$arrayRepository = new ArrayResourceRepository($context);
$context->addRepository($arrayRepository);

$loader = new ResourceLoader();

$yaml = file_get_contents(__DIR__ . '/xillion.manifest.yaml');
$manifestConfig = Yaml::parse($yaml);

$cache = new Psr16Cache(new FilesystemAdapter('example', 3600, __DIR__ . '/cache'));
$loader->loadManifest($arrayRepository, $manifestConfig, $cache);

/*
$filenames = [
    __DIR__ . '/../assets/xacml-10.xillion.cloud.yaml',
    __DIR__ . '/../assets/core.xillion.cloud.yaml',
    __DIR__ . '/example.linkorb.com.yaml',
];

foreach ($filenames as $filename) {
    if (!file_exists($filename)) {
        throw new RuntimeException("File not found: " . $filename);
    }

    $yaml = file_get_contents($filename);
    $config = Yaml::parse($yaml);
    $loader->load($arrayRepository, $config['resources']);
}
*/



foreach ($context->getResources() as $resource) {
    echo "\e[32m" . $resource->getId() . "\e[0m";
    if ($resource->hasAttribute('core.xillion.cloud/alias')) {
        $v = $resource->getAttribute('core.xillion.cloud/alias');
        echo " (\e[96m" . $v . "\e[0m)";
    }
    echo ":" . PHP_EOL;
    foreach ($resource->getAttributes() as $key=>$values) {
        if (is_array($values)) {
            $v = '[';
            foreach ($values as $value) {
                $v .= $value . ', ';
            }
            $values = trim($v, ' ,') . ']';
        }
        echo "  \e[33m" . $key . "\e[0m: \e[97m" .  $values . "\e[0m" . PHP_EOL;
    }
}



$validator = new Validator($context);
// $validator->validateResourceContext($context);

foreach ($context->getResources() as $resource) {
    $violations = $validator->validateResource($resource);
}

$resources = $context->getResourcesByAttribute(
    'core.xillion.cloud/profiles',
    'example.linkorb.com/profiles/user'
);
foreach ($resources as $resource) {
    echo "* " . $resource['example.linkorb.com/ubid'] . PHP_EOL;
}

$resources = $context->getResourcesByAttribute(
    'core.xillion.cloud/profiles',
    'core.xillion.cloud/profiles/profile'
);
foreach ($resources as $resource) {
    echo "* " . $resource->getId() . PHP_EOL;
}
print_r($violations);



// Instantiate a regular plain-old PHP object
$user = new User('joe', 'Joe Johnson', 'joe@example.web', ['management', 'sales']);
$project = new Project('wd', 'World Domination', ['sales', 'support']);

// Instantiate resolver

$providers = [
    new ProjectResourceProvider(),
];

$resolver = new ResourceResolver($context, $providers);

// Resolve attribute collection from regular object
$resource = $resolver->resolve($user);
echo "=== USER ===\n";
foreach ($resource->getAttributes() as $k=>$v) {
    if (is_string($v)) {
        echo "  " . $k . ": " . (string)$v . PHP_EOL;
    }
    $issues = $validator->validateResource($resource);
    if (count($issues)>0) {
        print_r($issues);
    }
}

$resource = $resolver->resolve($project);
echo "=== PROJECT ===\n";
foreach ($resource->getAttributes() as $k=>$v) {
    if (is_string($v)) {
        echo "  " . $k . ": " . (string)$v . PHP_EOL;
    }
    $issues = $validator->validateResource($resource);
    if (count($issues)>0) {
        print_r($issues);
    }
}


$card = $context->getResource('example.linkorb.com/cards/123');
echo($card['core.xillion.cloud/alias']) . PHP_EOL;

$assignee = $card->resolve('example.linkorb.com/assignee');

echo "Assignee: " . $assignee->getId() . PHP_EOL;

$members = $card->resolve('example.linkorb.com/members');
foreach ($members as $member) {
    echo "Member: " . $member->getId() . PHP_EOL;
}

echo($card['core.xillion.cloud/display']) . PHP_EOL;
// $validator->validateResource($resource);
