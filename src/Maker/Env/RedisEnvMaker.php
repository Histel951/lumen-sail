<?php
declare(strict_types=1);

namespace Histel\LumenSail\Maker\Env;

use Histel\LumenSail\DockerServicesEnum;

class RedisEnvMaker extends AbstractEnvMaker
{
    public function make(string $env = ''): string
    {
        $serviceName = DockerServicesEnum::REDIS;

        $this->builder->setEnv($env)
            ->replaceOrAdd('/REDIS_HOST=(.*)/', "REDIS_HOST=$serviceName");

        return $this->builder->getEnv();
    }
}