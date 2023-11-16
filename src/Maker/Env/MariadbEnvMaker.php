<?php
declare(strict_types=1);

namespace Histel\LumenSail\Env;

class MariadbEnvMaker extends AbstractEnvMaker
{
    public function make(): string
    {
        $this->replaceOrAdd('DB_USERNAME=root', "DB_USERNAME=sail");
        $this->replaceOrAdd('DB_HOST=127.0.0.1', 'DB_HOST=mariadb');

        if (preg_match('/DB_PASSWORD=(.*)/', $this->env)) {
            $this->env = preg_replace('/DB_PASSWORD=(.*)/', "DB_PASSWORD=password", $this->env);
        } else {
            $this->add('DB_PASSWORD=password');
        }

        return $this->env;
    }
}