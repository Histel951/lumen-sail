<?php
declare(strict_types=1);

namespace Histel\LumenSail\Maker\Env;

use Histel\LumenSail\DockerServicesEnum;

class MemcachedEnvMaker extends AbstractEnvMaker
{
    public function make(string $env = ''): string
    {
        $serviceName = DockerServicesEnum::MEMCACHED;

        $this->builder->setEnv($env)
            ->replaceOrAdd('/MEMCACHED_HOST=(.*)/', "MEMCACHED_HOST=$serviceName");

        return $this->builder->getEnv();
    }
}