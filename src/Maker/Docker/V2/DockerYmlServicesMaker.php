<?php
declare(strict_types=1);

namespace Histel\LumenSail\Maker\Docker\V2;

use Histel\LumenSail\Maker\Docker\AbstractDockerMaker;
use Illuminate\Support\Collection;
use Symfony\Component\Yaml\Yaml;

class DockerYmlServicesMaker extends AbstractDockerMaker
{
    public function make(array $services = [], array $config = []): array
    {
        collect($services)
            ->filter(function ($service) use ($config) {
                return ! array_key_exists($service, $config['services'] ?? []);
            })->each(function ($service) use (&$config) {
                $config['services'][$service] = Yaml::parseFile(base_path("vendor/laravel/sail/stubs/$service.stub"))[$service];
            });

        // Replace Selenium with ARM base container on Apple Silicon...
        if (in_array('selenium', $services) && in_array(php_uname('m'), ['arm64', 'aarch64'])) {
            $config['services']['selenium']['image'] = 'seleniarm/standalone-chromium';
        }

        return $config;
    }
}