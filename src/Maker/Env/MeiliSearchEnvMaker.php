<?php
declare(strict_types=1);

namespace Histel\LumenSail\Maker\Env;

use Histel\LumenSail\DockerServicesEnum;

class MeiliSearchEnvMaker extends AbstractEnvMaker
{
    public function make(string $env = ''): string
    {
        $serviceName = DockerServicesEnum::MEILI_SEARCH;

        $this->builder->setEnv($env)
            ->replaceOrAdd('/SCOUT_DRIVER=(.*)/', "SCOUT_DRIVER=$serviceName")
            ->replaceOrAdd('/"MEILISEARCH_HOST=(.*)/', "MEILISEARCH_HOST=http://meilisearch:7700\n");

        return $this->builder->getEnv();
    }
}