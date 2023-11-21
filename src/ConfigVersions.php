<?php
declare(strict_types=1);

namespace Histel\LumenSail;

use Symfony\Component\Yaml\Yaml;

class ConfigVersions
{
    /**
     * @return string|array
     */
    public function dockerCompose()
    {
        $composePath = base_path('docker-compose.stub');

        $compose = file_exists($composePath)
            ? Yaml::parseFile($composePath)
            : Yaml::parse(file_get_contents(base_path('vendor/laravel/sail/stubs/docker-compose.stub')));
    }
}