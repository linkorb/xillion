<?php

namespace Xillion\Core\Validator;

use Xillion\Core\Resource\ResourceInterface;
use Xillion\Core\ResourceContext\ResourceContextInterface;

class Validator
{
    public function __construct(ResourceContextInterface $context)
    {
        $this->context = $context;
    }

    public function validateAttribute(string $id, $value): array
    {
        $attributeResource = $this->context->getResource($id);
        if (!$attributeResource) {
            $issue = new ValidationIssue(ValidationIssue::INFO, 'Undefined attribute: ' . $id);
            return [$issue];
        }

        $dataTypeId = $attributeResource->getAttribute('https://core.xillion.cloud/xillion/attributes/data-type') ?? null;
        if (!$dataTypeId) {
            $issue = new ValidationIssue(ValidationIssue::ERROR, 'Data type not specified on attribute: ' . $id);
            return [$issue];
        }
        $dataTypeResource = $this->context->getResource($dataTypeId);
        if (!$dataTypeResource) {
            $issue = new ValidationIssue(ValidationIssue::ERROR, 'Unregistered data type: ' . $dataTypeId);
            return [$issue];
        }

        $isArray = $attributeResource->getAttribute('https://core.xillion.cloud/xillion/attributes/is-array') ?? false;
        $phpValidatorClassName = $dataTypeResource->getAttribute('https://core.xillion.cloud/xillion/attributes/php-validator-class');
        if ($phpValidatorClassName) {

            $values = $value;
            if (!$isArray) {
                $values = [$value];
            }

            // echo '  PHP_VALIDATOR_CLASS: ' . $phpValidatorClassName . PHP_EOL;
            $t = new $phpValidatorClassName($dataTypeId);
            foreach ($values as $v) {
                try {
                    $t->validate($v);
                } catch (\Exception $e) {
                    $issue = new ValidationIssue(ValidationIssue::ERROR, "Value does't validate against it's attribute's (" . $id . ") data-type (" . $dataTypeId . "): " . $v);
                    return [$issue];
                }
            }
        }
        return []; // all ok!
    }

    public function validateResource(ResourceInterface $resource): array
    {
        $issues = [];
        // echo PHP_EOL . "VALIDATING " . $resource->getId() . "\n";
        foreach ($resource->getAttributes() as $id=>$value) {
            $newIssues = $this->validateAttribute($id, $value);
            $issues = array_merge($issues, $newIssues);
        }

        $profileIds = $resource->getAttribute('https://core.xillion.cloud/xillion/attributes/profiles') ?? [];
        foreach ($profileIds as $profileId) {
            $profileResource = $this->context->getResource($profileId);
            if (!$profileResource) {
                $issue = new ValidationIssue(ValidationIssue::INFO, "Resource (" . $resource->getId() . ") implements an unregistered profile (" . $profileId . ")");
                return [$issue];
            }
            // echo "  PROFILE: " . $profileResource->getId() . PHP_EOL;
            $requiredAttributeIds = $profileResource->getAttribute('https://core.xillion.cloud/xillion/attributes/required-attributes') ?? [];
            foreach ($requiredAttributeIds as $requiredAttributeId) {
                // echo "    REQUIRES ATTRIBUTE: " . $requiredAttributeId . PHP_EOL;
                if (!$resource->hasAttribute($requiredAttributeId)) {
                    $issue = new ValidationIssue(ValidationIssue::ERROR, "Resource (" . $resource->getId() . ") misses required attribute (" . $requiredAttributeId . ") from profile (" . $profileId . ")");
                    return [$issue];
                }
            }
        }
        return $issues;
    }

    public function validateResourceContext(ResourceContextInterface $context): bool
    {
        foreach ($context->getResources() as $Resource) {
            $this->validateResource($Resource);
        }
        return true;
    }
}
