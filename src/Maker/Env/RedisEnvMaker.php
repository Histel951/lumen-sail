<?php
declare(strict_types=1);

namespace Histel\LumenSail\Maker\Env;

class RedisEnvMaker extends AbstractEnvMaker
{
    public function make(): string
    {
        $this->replaceOrAdd('REDIS_HOST=127.0.0.1', 'REDIS_HOST=redis');

        return $this->env;
    }
}