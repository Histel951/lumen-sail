<?php
declare(strict_types=1);

namespace Histel\LumenSail\Builder;

use Histel\LumenSail\Builder\Docker\DockerYmlReplaceBuilder;
use Histel\LumenSail\Builder\Env\EnvBuilder;

/*
 * Класс будет возращать актуальную версию реализации билдера конфигов,
 * в зависимости от версии установленной laravel/sail
 */
class BuilderFactory implements BuilderFactoryInterface
{
    /**
     * @param string $config
     * @return BuilderInterface
     */
    public function dockerYml(string $config): BuilderInterface
    {
        return new DockerYmlReplaceBuilder($config);
    }

    /**
     * @param string $config
     * @return BuilderInterface
     */
    public function env(string $config): BuilderInterface
    {
        return new EnvBuilder($config);
    }
}