<?php
declare(strict_types=1);

namespace Histel\LumenSail\Maker\Docker\V2;

use Histel\LumenSail\DockerServicesEnum as DSE;
use Histel\LumenSail\Maker\Docker\AbstractDockerMaker;

class DockerYmlDependsMaker extends AbstractDockerMaker
{
    public function make(array $services = [], array $config = []): array
    {
        $config['services']['laravel.test']['depends_on'] = collect($config['services']['laravel.test']['depends_on'] ?? [])
            ->merge($services)
            ->unique()
            ->values()
            ->all();

        return $config;
    }
}