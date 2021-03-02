<?php

namespace Example\Entity;

use Xillion\Core\ResourceResolver\ResourceConfigInterface;

class User implements ResourceConfigInterface
{
    protected $id;
    protected $displayName;
    protected $email;
    protected $groupNames;

    public function __construct(string $id, string $displayName, string $email, array $groupNames)
    {
        $this->id = $id;
        $this->displayName = $displayName;
        $this->email = $email;
        $this->groupNames = $groupNames;
    }

    public function getResourceConfig(): array
    {
        return [
            '$id' => $this->id,
            'core.xillion.cloud/display' => $this->id,
            'core.xillion.cloud/profiles' => [
                'example.linkorb.com/profiles/user',
            ],
            'urn:oasis:names:tc:xacml:1.0:subject:subject-id' => $this->id,
            'example.linkorb.com/ubid' => $this->id,
            'example.linkorb.com/user-groups' => $this->groupNames,
            'http://schemas.xmlsoap.org/ws/2005/05/identity/claims/givenname' => $this->displayName,
            'http://schemas.xmlsoap.org/ws/2005/05/identity/claims/emailaddress' => $this->email,
        ];
    }
}
