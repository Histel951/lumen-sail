<?php
declare(strict_types=1);

namespace Histel\LumenSail\Builder\Env;

use Histel\LumenSail\Builder\BuilderInterface;
use Histel\LumenSail\Maker\Env\MariadbEnvMaker;
use Histel\LumenSail\Maker\Env\MeiliSearchEnvMaker;
use Histel\LumenSail\Maker\Env\MemcachedEnvMaker;
use Histel\LumenSail\Maker\Env\MysqlEnvMaker;
use Histel\LumenSail\Maker\Env\PsqlEnvMaker;
use Histel\LumenSail\Maker\Env\RedisEnvMaker;
use Histel\LumenSail\Maker\MakerInterface;

class EnvBuilder implements BuilderInterface
{
    /**
     * Latest version of laravel sail which this builder supports.
     * @var string
     */
    const LAST_VERSION = 'now';

    /**
     * .env configs.
     * @var string
     */
    private string $env;

    public function __construct(string $env)
    {
        $this->env = $env;
    }

    /**
     * Makers forming configs for services.
     *
     * @var array|string[]
     */
    protected array $servicesEnv = [
        'pgsql' => PsqlEnvMaker::class,
        'mariadb' => MariadbEnvMaker::class,
        'mysql' => MysqlEnvMaker::class,
        'meilisearch' => MeiliSearchEnvMaker::class,
        'memcached' => MemcachedEnvMaker::class,
        'redis' => RedisEnvMaker::class
    ];

    public function build(array $services): string
    {
        foreach ($this->servicesEnv as $service => $envClass) {
            if (in_array($service, $services)) {
                /**
                 * @var MakerInterface $envMaker
                 */
                $envMaker = new $envClass($this->env);
                $this->env = $envMaker->make();
            }
        }

        return $this->env;
    }
}