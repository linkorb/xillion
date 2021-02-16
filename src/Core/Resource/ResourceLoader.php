<?php

namespace Xillion\Core\Resource;

use Xillion\Core\ResourceRepository\ResourceRepositoryInterface;
use Symfony\Component\Yaml\Yaml;
use Psr\SimpleCache\CacheInterface;

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

    public function loadManifest(ResourceRepositoryInterface $repository, array $manifest, ?CacheInterface $cache): void
    {
        foreach (($manifest['dependencies'] ?? []) as $packageName => $packageConfig) {
            $yaml = null;
            $cacheKey = 'xillion.package.' . $packageName;
            if ($cache) {
                $yaml = $cache->get($cacheKey, null);
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

            if ($cache) {
                $cache->set($cacheKey, $yaml);
            }

            $config = Yaml::parse($yaml);
            $this->load($repository, $config['resources'] ?? []);
        }
    }

}
