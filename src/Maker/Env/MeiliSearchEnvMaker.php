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
            ->replaceOrAdd('/^SCOUT_DRIVER=(.*)/m', "SCOUT_DRIVER=$serviceName")
            ->replaceOrAdd('/^MEILISEARCH_HOST=(.*)/m', "MEILISEARCH_HOST=http://meilisearch:7700\n")
            ->replaceOrAdd('/^MEILISEARCH_NO_ANALYTICS=(.*)/m', "MEILISEARCH_NO_ANALYTICS=false\n");

        return $this->builder->getEnv();
    }
}