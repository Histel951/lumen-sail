<?php
declare(strict_types=1);

namespace Histel\LumenSail\Maker\Docker\V1;

use Histel\LumenSail\DockerServicesEnum as DSE;
use Histel\LumenSail\Maker\Docker\AbstractDockerMaker;

class DockerYmlVolumesMaker extends AbstractDockerMaker
{
    protected array $usesServices = [
        DSE::MYSQL,
        DSE::PGSQL,
        DSE::MARIADB,
        DSE::REDIS,
        DSE::MINIO,
        DSE::MEILI_SEARCH,
    ];

    public function make(array $services = []): string
    {
        return collect($services)
            ->filter(function ($service) {
                return in_array($service, $this->usesServices);
            })->map(function ($service) {
                return "    sail-$service:\n        driver: local";
            })->whenNotEmpty(function ($collection) {
                return $collection->prepend('volumes:');
            })->implode("\n");
    }
}