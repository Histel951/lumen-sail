<?php
declare(strict_types=1);

namespace Histel\LumenSail\Maker\Docker;

class DockerYmlServicesMaker extends AbstractDockerMaker
{
    public function make(array $services = []): string
    {
        return rtrim(collect($services)->map(function ($service) {
            return file_get_contents(base_path("vendor/laravel/sail/stubs/$service.stub"));
        })->implode(''));
    }
}