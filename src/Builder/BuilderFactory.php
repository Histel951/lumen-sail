<?php
declare(strict_types=1);

namespace Histel\LumenSail\Builder;

use Exception;
use Histel\LumenSail\Builder\Docker\DockerYmlReplaceBuilder;
use Histel\LumenSail\Builder\Docker\DockerYmlStubsBuilder;
use Histel\LumenSail\Builder\Env\EnvBuilder;
use Histel\LumenSail\Version;

class BuilderFactory implements BuilderFactoryInterface
{
    protected array $dockerBuildersVersion = [
        'V1' => DockerYmlReplaceBuilder::class,
        'V2' => DockerYmlStubsBuilder::class,
    ];

    /**
     * Helper for getting the latest version for a package "laravel/sail".
     *
     * @var Version
     */
    private Version $version;

    public function __construct()
    {
        $this->version = new Version();
    }

    /**
     * Returns the current docker.yml builder implementation for the installed version "laravel/sail".
     *
     * @param string|array $config
     * @throws Exception
     * @return BuilderInterface
     */
    public function dockerYml($config): BuilderInterface
    {
        $class = $this->dockerBuildersVersion[$this->version->getActual()];

        return new $class($config);
    }

    /**
     * Returns the current .env builder implementation for the installed version "laravel/sail".
     *
     * @param string $config
     * @return BuilderInterface
     */
    public function env(string $config): BuilderInterface
    {
        return new EnvBuilder($config);
    }
}