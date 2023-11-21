<?php
declare(strict_types=1);

namespace Histel\LumenSail\Maker\Docker\V2;

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

    public function make(array $services = [], array $config = []): array
    {
        $config = collect($services)
            ->filter(function ($service) {
                return in_array($service, $this->usesServices);
            })->filter(function ($service) use ($config) {
                return ! array_key_exists($service, $config['volumes'] ?? []);
            })->each(function ($service) use (&$config) {
                $config['volumes']["sail-{$service}"] = ['driver' => 'local'];
            });

        if (empty($config['volumes'])) {
            unset($config['volumes']);
        }

        return $config;
    }
}