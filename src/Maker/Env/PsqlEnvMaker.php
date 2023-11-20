<?php
declare(strict_types=1);

namespace Histel\LumenSail\Maker\Env;

use Histel\LumenSail\DockerServicesEnum;

class PsqlEnvMaker extends AbstractEnvMaker
{
    public function make(string $env = ''): string
    {
        $serviceName = DockerServicesEnum::PGSQL;

        $this->builder->setEnv($env)
            ->replaceOrAdd('/DB_USERNAME=(.*)/', "DB_USERNAME=sail")
            ->replaceOrAdd('/DB_CONNECTION=(.*)/', "DB_CONNECTION=$serviceName")
            ->replaceOrAdd('/DB_HOST=(.*)/', "DB_HOST=$serviceName")
            ->replaceOrAdd('/DB_PORT=(.*)/', 'DB_PORT=5432')
            ->replaceOrAdd('/DB_PASSWORD=(.*)/', 'DB_PASSWORD=password');

        return $this->builder->getEnv();
    }
}