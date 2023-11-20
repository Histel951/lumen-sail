<?php

namespace Histel\LumenSail\Console\Commands;

use Histel\LumenSail\Builder\BuilderFactory;
use Histel\LumenSail\Builder\BuilderInterface;
use Illuminate\Console\Command;
use Histel\LumenSail\DockerServicesEnum as DSE;

class SailInstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sail:install {--with= : The services that should be included in the installation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Laravel Sail\'s default Docker Compose file';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $dockerCompose = $this->getDockerComposeYml();
        $env = $this->receiveEnv();
        $services = $this->receiveServices();

        $builderFactory = new BuilderFactory();
        $this->createConfig($builderFactory->env($env), '.env', $services);
        $this->createConfig($builderFactory->dockerYml($dockerCompose), 'docker-compose.yml', $services);

        $this->publishStubs();

        $this->info('Sail scaffolding installed successfully.');
    }

    /**
     * Return laravel/sail docker-compose stub to string;
     *
     * @return string
     */
    private function getDockerComposeYml(): string
    {
        return file_get_contents($this->laravel->basePath('vendor/laravel/sail/stubs/docker-compose.stub'));
    }

    /**
     * Receive env config.
     *
     * @return string
     */
    private function receiveEnv(): string
    {
        $env = file_get_contents($this->laravel->basePath('.env'));
        if (!preg_match('/COMPOSE_PROJECT_NAME=(.*)/', $env)) {
            $composeProjectName = $this->ask('Write the composer project name:');
            $env .= "\nCOMPOSE_PROJECT_NAME=$composeProjectName\n";
        }

        return $env;
    }

    /**
     * Select services.
     *
     * @return array|string[]
     */
    private function receiveServices(): array
    {
        if ($this->option('with')) {
            $services = $this->option('with') == 'none' ? [] : explode(',', $this->option('with'));
        } elseif ($this->option('no-interaction')) {
            $services = [DSE::MYSQL, DSE::REDIS, DSE::SELENIUM, DSE::MAIL_HOG];
        } else {
            $services = $this->choice('Which services would you like to install?', [
                DSE::MYSQL,
                DSE::PGSQL,
                DSE::MARIADB,
                DSE::REDIS,
                DSE::MEMCACHED,
                DSE::MEILI_SEARCH,
                DSE::MINIO,
                DSE::MAIL_HOG,
                DSE::SELENIUM,
            ], 0, null, true);
        }

        return $services;
    }

    /**
     * Creates a config file.
     *
     * @param BuilderInterface $builder
     * @param string $basePath
     * @param array $services
     * @return void
     */
    private function createConfig(BuilderInterface $builder, string $basePath, array $services): void
    {
        $environment = $builder->build($services);
        file_put_contents($this->laravel->basePath($basePath), $environment);
    }

    /**
     * Publishing stubs.
     *
     * @return void
     */
    private function publishStubs(): void
    {
        copy(__DIR__ . '/../../../stubs/server.php', $this->laravel->basePath('server.php'));
    }
}
