<?php

namespace Xillion\Core\Resource;

interface ResourceInterface
{
    public function getAttributes(): array;
    public function hasAttribute(string $key): bool;
    public function getAttribute(string $key);
}
