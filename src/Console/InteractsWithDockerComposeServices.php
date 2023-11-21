<?php
declare(strict_types=1);

namespace Histel\LumenSail\Console;

use Exception;
use Histel\LumenSail\DockerServicesEnum as DSE;
use Histel\LumenSail\Version;

trait InteractsWithDockerComposeServices
{
    /**
     * Default services by version.
     *
     * @var array|array[]
     */
    protected array $defaultServicesVersion = [
        'V1' => [DSE::MYSQL, DSE::REDIS, DSE::SELENIUM, DSE::MAIL_HOG],
        'V2' => [DSE::MYSQL, DSE::REDIS, DSE::SELENIUM, DSE::MAIL_PIT]
    ];

    /**
     * Services by version.
     *
     * @var array|array[]
     */
    protected array $servicesVersion = [
        'V1' => [
            DSE::MYSQL,
            DSE::PGSQL,
            DSE::MARIADB,
            DSE::REDIS,
            DSE::MEMCACHED,
            DSE::MEILI_SEARCH,
            DSE::MINIO,
            DSE::MAIL_HOG,
            DSE::SELENIUM,
        ],
        'V2' => [
            DSE::MYSQL,
            DSE::PGSQL,
            DSE::MARIADB,
            DSE::REDIS,
            DSE::MEMCACHED,
            DSE::MEILI_SEARCH,
            DSE::MINIO,
            DSE::MAIL_PIT,
            DSE::SELENIUM,
            DSE::SOKETI,
        ]
    ];

    /**
     * Return laravel/sail docker-compose stub to string;
     *
     * @return string
     */
    protected function getDockerComposeYml(): string
    {
        return file_get_contents($this->laravel->basePath('vendor/laravel/sail/stubs/docker-compose.stub'));
    }

    /**
     * Get services.
     *
     * @return array
     * @throws Exception
     */
    protected function getServices(): array
    {
        return $this->servicesVersion[$this->version()];
    }

    /**
     * Get default versions.
     *
     * @return array
     * @throws Exception
     */
    protected function getDefaultServices(): array
    {
        return $this->defaultServicesVersion[$this->version()];
    }

    /**
     * Get version.
     *
     * @return string
     * @throws Exception
     */
    protected function version(): string
    {
        return (new Version())->getActual();
    }

    /**
     * Configure PHPUnit to use the dedicated testing database.
     *
     * @return void
     */
    protected function configurePhpUnit()
    {
        if (! file_exists($path = $this->laravel->basePath('phpunit.xml'))) {
            $path = $this->laravel->basePath('phpunit.xml.dist');
        }

        $phpunit = file_get_contents($path);

        $phpunit = preg_replace('/^.*DB_CONNECTION.*\n/m', '', $phpunit);
        $phpunit = str_replace('<!-- <env name="DB_DATABASE" value=":memory:"/> -->', '<env name="DB_DATABASE" value="testing"/>', $phpunit);

        file_put_contents($this->laravel->basePath('phpunit.xml'), $phpunit);
    }

    /**
     * Install the devcontainer.json configuration file.
     *
     * @return void
     */
    protected function installDevContainer()
    {
        if (! is_dir($this->laravel->basePath('.devcontainer'))) {
            mkdir($this->laravel->basePath('.devcontainer'), 0755, true);
        }

        file_put_contents(
            $this->laravel->basePath('.devcontainer/devcontainer.json'),
            file_get_contents($this->laravel->basePath('vendor/laravel/sail/stubs/devcontainer.stub'))
        );

        $environment = file_get_contents($this->laravel->basePath('.env'));

        $environment .= "\nWWWGROUP=1000";
        $environment .= "\nWWWUSER=1000\n";

        file_put_contents($this->laravel->basePath('.env'), $environment);
    }
}