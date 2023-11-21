<?php
declare(strict_types=1);

namespace Histel\LumenSail\Maker\Env;

use Histel\LumenSail\DockerServicesEnum;

class MariadbEnvMaker extends AbstractEnvMaker
{
    public function make(string $env = ''): string
    {
        $serviceName = DockerServicesEnum::MARIADB;

        $this->builder->setEnv($env)
            ->replaceOrAdd('/^DB_USERNAME=(.*)/m', "DB_USERNAME=sail")
            ->replaceOrAdd('/^DB_HOST=(.*)/m', "DB_HOST=$serviceName")
            ->replaceOrAdd('/^DB_PASSWORD=(.*)/m', 'DB_PASSWORD=password');

        return $this->builder->getEnv();
    }
}