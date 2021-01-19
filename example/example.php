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

use Symfony\Component\Yaml\Yaml;

$context = new ResourceContext();
// $context = new ChainRepository();
$arrayRepository = new ArrayResourceRepository($context);
$context->addRepository($arrayRepository);


$filenames = [
    __DIR__ . '/../assets/xacml-10.xillion.cloud.yaml',
    __DIR__ . '/../assets/core.xillion.cloud.yaml',
    __DIR__ . '/example.linkorb.com.yaml',
];
$loader = new ResourceLoader();

foreach ($filenames as $filename) {
    if (!file_exists($filename)) {
        throw new RuntimeException("File not found: " . $filename);
    }

    $yaml = file_get_contents($filename);
    $config = Yaml::parse($yaml);
    $loader->load($arrayRepository, $config['resources']);
}

foreach ($context->getResources() as $resource) {
    echo "\e[32m" . $resource->getId() . "\e[0m";
    if ($resource->hasAttribute('https://core.xillion.cloud/xillion/attributes/alias')) {
        $v = $resource->getAttribute('https://core.xillion.cloud/xillion/attributes/alias');
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
    'https://core.xillion.cloud/xillion/attributes/profiles',
    'https://example.linkorb.com/xillion/profiles/user'
);
foreach ($resources as $resource) {
    echo "* " . $resource['https://example.linkorb.com/xillion/attributes/ubid'] . PHP_EOL;
}

$resources = $context->getResourcesByAttribute(
    'https://core.xillion.cloud/xillion/attributes/profiles',
    'https://core.xillion.cloud/xillion/profiles/profile'
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


$card = $context->getResource('https://example.linkorb.com/xillion/cards/123');
echo($card['https://core.xillion.cloud/xillion/attributes/alias']) . PHP_EOL;

$assignee = $card->resolve('https://example.linkorb.com/xillion/attributes/assignee');

echo "Assignee: " . $assignee->getId() . PHP_EOL;

$members = $card->resolve('https://example.linkorb.com/xillion/attributes/members');
foreach ($members as $member) {
    echo "Member: " . $member->getId() . PHP_EOL;
}

// $validator->validateResource($resource);
