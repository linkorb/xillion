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
            foreach ($attributes as $k=>$subAttributes) {
                // Check if attribute name ends in dollar postfix
                if (substr($k, -1, 1)=='$') {
                    unset($attributes[$k]); // unset the dollar postfixed attribute
                    $k = substr($k, 0, -1); // strip dollar postfix
                    // determine an id for the sub resource based on a hash of the content
                    $json = json_encode($subAttributes);
                    $subResourceId = 'inline/' . sha1($json);

                    // Register the sub resource
                    $subResource = new Resource($repository, $subResourceId, $subAttributes);
                    $repository->addResource($subResource);

                    // Add a new attribute to the original resource referencing the new subresource
                    $attributes[$k] = $subResourceId;
                }
            }
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
