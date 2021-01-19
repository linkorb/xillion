<?php

namespace Xillion\Core\ResourceRepository;

use Xillion\Core\Resource\ResourceInterface;
use Xillion\Core\ResourceContext\ResourceContextInterface;

interface ResourceRepositoryInterface
{
    public function getResource(string $id): ?ResourceInterface;
    public function getContext(): ResourceContextInterface;
}
