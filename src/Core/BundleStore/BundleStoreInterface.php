<?php

namespace Xillion\Core\BundleStore;

interface BundleStoreInterface
{
    public function getBundle(string $bundleId): ?array;
    public function setBundle(string $bundleId, array $config): void;
}
