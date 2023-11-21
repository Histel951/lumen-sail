<?php
declare(strict_types=1);

namespace Histel\LumenSail\Builder\Env;

use Histel\LumenSail\Builder\AbstractBuilder;
use Histel\LumenSail\Maker\Env\MailPitEnvMaker;
use Histel\LumenSail\Maker\Env\MariadbEnvMaker;
use Histel\LumenSail\Maker\Env\MeiliSearchEnvMaker;
use Histel\LumenSail\Maker\Env\MemcachedEnvMaker;
use Histel\LumenSail\Maker\Env\MysqlEnvMaker;
use Histel\LumenSail\Maker\Env\PsqlEnvMaker;
use Histel\LumenSail\Maker\Env\RedisEnvMaker;
use Histel\LumenSail\DockerServicesEnum as DSE;
use Histel\LumenSail\Maker\Env\SoketiEnvMaker;

class EnvBuilder extends AbstractBuilder
{
    /**
     * Latest version of laravel sail which this builder supports.
     * @var string
     */
    const LAST_VERSION = 'now';

    /**
     * Makers forming configs for services.
     *
     * @var array|string[]
     */
    protected array $makersClasses = [
        DSE::PGSQL => PsqlEnvMaker::class,
        DSE::MARIADB => MariadbEnvMaker::class,
        DSE::MYSQL => MysqlEnvMaker::class,
        DSE::MEILI_SEARCH => MeiliSearchEnvMaker::class,
        DSE::MEMCACHED => MemcachedEnvMaker::class,
        DSE::REDIS => RedisEnvMaker::class,
        DSE::SOKETI => SoketiEnvMaker::class,
        DSE::MAIL_PIT => MailPitEnvMaker::class,
    ];

    public function build(array $services): string
    {
        foreach ($this->makers as $makerDTO) {
            if (in_array($makerDTO->getName(), $services)) {
                $this->config = $makerDTO->getMaker()->make($this->config);
            }
        }

        return $this->config;
    }
}