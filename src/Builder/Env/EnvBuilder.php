<?php
declare(strict_types=1);

namespace Histel\LumenSail\Builder\Env;

use Histel\LumenSail\Builder\AbstractBuilder;
use Histel\LumenSail\Builder\BuilderInterface;
use Histel\LumenSail\Maker\Env\MariadbEnvMaker;
use Histel\LumenSail\Maker\Env\MeiliSearchEnvMaker;
use Histel\LumenSail\Maker\Env\MemcachedEnvMaker;
use Histel\LumenSail\Maker\Env\MysqlEnvMaker;
use Histel\LumenSail\Maker\Env\PsqlEnvMaker;
use Histel\LumenSail\Maker\Env\RedisEnvMaker;
use Histel\LumenSail\Maker\MakerInterface;

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
        'pgsql' => PsqlEnvMaker::class,
        'mariadb' => MariadbEnvMaker::class,
        'mysql' => MysqlEnvMaker::class,
        'meilisearch' => MeiliSearchEnvMaker::class,
        'memcached' => MemcachedEnvMaker::class,
        'redis' => RedisEnvMaker::class
    ];

    public function build(array $services): string
    {
        foreach ($this->makers as $makerDTO) {
            if (in_array($makerDTO->getName(), $services)) {
                /**
                 * @var MakerInterface $envMaker
                 */
                $envMaker = new $envClass($this->config);
                $this->config = $envMaker->make();
            }
        }

        return $this->config;
    }
}