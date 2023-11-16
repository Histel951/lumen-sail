<?php
declare(strict_types=1);

namespace Histel\LumenSail\Maker\Docker;

class DockerYmlServicesMaker extends AbstractDockerMaker
{
    public function make(): string
    {
        return rtrim(collect($this->services)->map(function ($service) {
            return file_get_contents(base_path("vendor/laravel/sail/stubs/$service.stub"));
        })->implode(''));
    }
}