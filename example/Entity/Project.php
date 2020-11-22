<?php

namespace Example\Entity;

class Project
{
    protected $id;
    protected $displayName;
    protected $groupNames;

    public function __construct(string $id, string $displayName, array $groupNames)
    {
        $this->id = $id;
        $this->displayName = $displayName;
        $this->groupNames = $groupNames;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getDisplayName(): string
    {
        return $this->displayName;
    }

    public function getGroupNames(): array
    {
        return $this->groupNames;
    }
}
