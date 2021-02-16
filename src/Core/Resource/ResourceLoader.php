<?php

namespace Xillion\Core\Resource;

use Xillion\Core\ResourceRepository\ResourceRepositoryInterface;
use Symfony\Component\Yaml\Yaml;
use RuntimeException;

class ResourceLoader
{

    public function load(ResourceRepositoryInterface $repository, array $config): void
    {
        foreach ($config as $resourceId=>$attributes) {
            $resource = new Resource($repository, $resourceId, $attributes);
            $repository->addResource($resource);
        }
    }

    public function loadManifest(ResourceRepositoryInterface $repository, array $manifest, ?string $cachePath): void
    {
        foreach (($manifest['dependencies'] ?? []) as $packageName => $packageConfig) {
            $yaml = null;
            $filename = null;
            if ($cachePath) {
                if (!file_exists($cachePath)) {
                    mkdir($cachePath, 0777, true);
                }

                $filename = $cachePath  . '/' . $packageName . '.yaml';
                if (file_exists($filename)) {
                    $yaml = file_get_contents($filename);
                }
            }

            if (!$yaml) {
                $url = $packageConfig['url'] ?? null;
                if (!$url) {
                    throw new RuntimeException("Package $packageName does not have a source URL specified");
                }

                $yaml = file_get_contents($url);
            }

            if (!$yaml) {
                throw new RuntimeException("Could not load yaml definition for package " . $packageName);
            }

            if ($cachePath) {
                file_put_contents($filename, $yaml);
            }

            $config = Yaml::parse($yaml);
            $this->load($repository, $config['resources'] ?? []);
        }
    }

}
