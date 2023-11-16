<?php
declare(strict_types=1);

namespace Histel\LumenSail\Env;

class PsqlEnvMaker extends AbstractEnvMaker
{
    public function make(): string
    {
        $this->replaceOrAdd('DB_USERNAME=root', "DB_USERNAME=sail");
        $this->replaceOrAdd('DB_CONNECTION=mysql', 'DB_CONNECTION=psql');
        $this->replaceOrAdd('DB_HOST=127.0.0.1', 'DB_HOST=pgsql');
        $this->replaceOrAdd('DB_PORT=3306', 'DB_PORT=5432');
        $this->env = preg_replace("/DB_PASSWORD=(.*)/", "DB_PASSWORD=password", $this->env);

        return $this->env;
    }
}