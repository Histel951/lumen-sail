<?php
declare(strict_types=1);

namespace Histel\LumenSail\Maker\Docker\V1;

use Histel\LumenSail\DockerServicesEnum as DSE;
use Histel\LumenSail\Maker\Docker\AbstractDockerMaker;

class DockerYmlDependsMaker extends AbstractDockerMaker
{
    protected array $usesServices = [
        DSE::MYSQL,
        DSE::PGSQL,
        DSE::MARIADB,
        DSE::REDIS,
        DSE::SELENIUM,
    ];

    public function make(array $services = []): string
    {
        $depends =  collect($services)
            ->filter(function ($service) {
                return in_array($service, $this->usesServices);
            })->map(function ($service) {
                return "            - $service";
            })->whenNotEmpty(function ($collection) {
                return $collection->prepend('depends_on:');
            })->implode("\n");

        return empty($depends) ? '' : '        '.$depends;
    }
}