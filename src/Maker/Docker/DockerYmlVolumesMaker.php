<?php
declare(strict_types=1);

namespace Histel\LumenSail\Maker\Docker;

class DockerYmlVolumesMaker extends AbstractDockerMaker
{
    public function make(): string
    {
        return collect($this->services)
            ->filter(function ($service) {
                return in_array($service, ['mysql', 'pgsql', 'mariadb', 'redis', 'meilisearch', 'minio']);
            })->map(function ($service) {
                return "    sail-$service:\n        driver: local";
            })->whenNotEmpty(function ($collection) {
                return $collection->prepend('volumes:');
            })->implode("\n");
    }
}