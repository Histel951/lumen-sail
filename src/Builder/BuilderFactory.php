<?php
declare(strict_types=1);

namespace Histel\LumenSail\Builder\Docker;

use Histel\LumenSail\Builder\BuilderFactoryInterface;
use Histel\LumenSail\Builder\BuilderInterface;

/*
 * Класс будет возращать актуальную версию реализации билдера конфигов,
 * в зависимости от версии установленной laravel/sail
 */
class DockerYmlBuilderFactory implements BuilderFactoryInterface
{
    /**
     * @param string $config
     * @return BuilderInterface
     */
    public function actual($config = null): BuilderInterface
    {
        return new DockerYmlReplaceBuilder($config);
    }
}