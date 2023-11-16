<?php
declare(strict_types=1);

namespace Histel\LumenSail\Maker\Env;

class MeiliSearchEnvMaker extends AbstractEnvMaker
{
    public function make(): string
    {
        $this->add('SCOUT_DRIVER=meilisearch');
        $this->add("MEILISEARCH_HOST=http://meilisearch:7700\n");

        return $this->env;
    }
}