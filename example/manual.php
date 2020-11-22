<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Xillion\Core\Attribute\Attribute;
use Xillion\Core\Resource\Resource;
use Xillion\Core\ResourceType\ResourceType;
use Xillion\Core\AttributeDefinition\AttributeDefinition;
use Xillion\Core\AttributeDefinition\AttributeDefinitionRegistry;
use Xillion\Core\AttributeDefinition\AttributeDefinitionRegistryLoader;
use Xillion\Core\AttributeType\AttributeType;
use Xillion\Core\AttributeType\AttributeTypeRegistryLoader;
use Xillion\Core\Resolver\AttributeResolver;
use Xillion\Core\ResourceContext\ResourceContext;
use Xillion\Core\Validator\Validator;
use Xillion\Core\Matcher\Matcher;
use Symfony\Component\Yaml\Yaml;
use Example\User;

$stringType = new AttributeType('http://www.w3.org/2001/XMLSchema#string');

$subjectIdDefinition = new AttributeDefinition('urn:oasis:names:tc:xacml:1.0:subject:subject-id', $stringType);
$nameDefinition = new AttributeDefinition('http://schemas.xmlsoap.org/ws/2005/05/identity/claims/givenname', $stringType);
$emailDefinition = new AttributeDefinition('http://schemas.xmlsoap.org/ws/2005/05/identity/claims/emailaddress', $stringType);

$a1 = new Attribute($subjectIdDefinition, ["CN=Julius Hibbert"]);
$a2 = new Attribute($nameDefinition, ["Julius"]);
$a3 = new Attribute($emailDefinition, ["julius@example.com"]);

$ct = new ResourceType([$nameDefinition, $emailDefinition]);

$julius = new Resource('julius', [$a1, $a2, $a3], [$ct]);

$validator = new Validator();
$validator->validateResource($julius);

$context = new ResourceContext([$julius]);
$validator->validateResourceContext($context);


$julius2 = new Resource('julius', [$a1, $a2], [$ct]);

$matcher = new Matcher();

$Resources = $matcher->findResourcesInContext($context, ['urn:oasis:names:tc:xacml:1.0:subject:subject-id' => 'CN=Julius Hibbert']);
foreach ($Resources as $Resource) {
    $a = $Resource->getAttribute('urn:oasis:names:tc:xacml:1.0:subject:subject-id');
    $values = $a->getValues();
    foreach ($values as $value) {
        echo $value . PHP_EOL;
    }
}
