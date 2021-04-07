<?php

namespace Xillion\Core\BundleStore;

class FileBundleStore implements BundleStoreInterface
{
    protected $basePath;

    public function __construct(string $basePath)
    {
        $this->basePath = $basePath;
    }

    public function getBundle(string $bundleId): ?array
    {
        $filename = $this->basePath . '/' . $bundleId . '.json';
        $json = file_get_contents($filename);
        $config = json_decode($json, true);
        return $config;
    }

    public function setBundle(string $bundleId, array $config): void
    {
        $json = json_encode($config, JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
        $filename = $this->basePath . '/' . $bundleId . '.json';
        $path = dirname($filename);
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        file_put_contents($filename, $json);
    }
}
