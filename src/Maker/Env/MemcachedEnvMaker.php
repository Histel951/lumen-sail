<?php
declare(strict_types=1);

namespace Histel\LumenSail\Env;

class MemcachedEnvMaker extends AbstractEnvMaker
{
    public function make(): string
    {
        $this->replaceOrAdd('MEMCACHED_HOST=127.0.0.1', 'MEMCACHED_HOST=memcached');

        return $this->env;
    }
}