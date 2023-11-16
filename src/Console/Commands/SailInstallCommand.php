<?php

namespace Histel\LumenSail\Console\Commands;

use Histel\LumenSail\Maker\Docker\DockerYmlDependsMaker;
use Histel\LumenSail\Maker\Docker\DockerYmlServicesMaker;
use Histel\LumenSail\Maker\Docker\DockerYmlVolumesMaker;
use Histel\LumenSail\Maker\Env\MariadbEnvMaker;
use Histel\LumenSail\Maker\Env\MeiliSearchEnvMaker;
use Histel\LumenSail\Maker\Env\MemcachedEnvMaker;
use Histel\LumenSail\Maker\Env\MysqlEnvMaker;
use Histel\LumenSail\Maker\Env\PsqlEnvMaker;
use Histel\LumenSail\Maker\Env\RedisEnvMaker;
use Histel\LumenSail\Maker\MakerInterface;
use Illuminate\Console\Command;

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

    /**
     * @var array
     */
    protected array $serviceDocker = [
        'volumes' => [
            'class' => DockerYmlVolumesMaker::class,
            'services' => ['mysql', 'pgsql', 'mariadb', 'redis', 'meilisearch', 'minio']
        ],
        'depends' => [
            'class' => DockerYmlDependsMaker::class,
            'services' => ['mysql', 'pgsql', 'mariadb', 'redis', 'selenium']
        ],
        'services' => [
            'class' => DockerYmlServicesMaker::class,
            'services' => []
        ]
    ];

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $environment = file_get_contents($this->laravel->basePath('.env'));

        if (!preg_match('/COMPOSE_PROJECT_NAME=(.*)/', $environment)) {
            $composeProjectName = $this->ask('Write the composer project name:');
            $environment .= "\nCOMPOSE_PROJECT_NAME=$composeProjectName\n";
        }

        if ($this->option('with')) {
            $services = $this->option('with') == 'none' ? [] : explode(',', $this->option('with'));
        } elseif ($this->option('no-interaction')) {
            $services = ['mysql', 'redis', 'selenium', 'mailhog'];
        } else {
            $services = $this->gatherServicesWithSymfonyMenu();
        }

        $environment = $this->buildServiceEnv($environment, $services);
        file_put_contents($this->laravel->basePath('.env'), $environment);

        $dockerCompose = $this->buildDockerComposeYml($services);
        file_put_contents($this->laravel->basePath('docker-compose.yml'), $dockerCompose);

        copy(__DIR__ . '/../../../stubs/server.php', $this->laravel->basePath('server.php'));

        $this->info('Sail scaffolding installed successfully.');
    }

    /**
     * Gather the desired Sail services using a Symfony menu.
     *
     * @return array|string
     */
    protected function gatherServicesWithSymfonyMenu()
    {
        return $this->choice('Which services would you like to install?', [
            'mysql',
            'pgsql',
            'mariadb',
            'redis',
            'memcached',
            'meilisearch',
            'minio',
            'mailhog',
            'selenium',
        ], 0, null, true);
    }

    /**
     * Build the Docker Compose file.
     *
     * @param array $services
     * @return string
     */
    protected function buildDockerComposeYml(array $services): string
    {
        $dockerCompose = file_get_contents($this->laravel->basePath('vendor/laravel/sail/stubs/docker-compose.stub'));

        foreach ($this->serviceDocker as $config => $item) {
            /**
             * @var MakerInterface $dockerYmlMaker
             */
            $dockerYmlMaker = new $item['class']($services, $item['services']);
            $configValue = $dockerYmlMaker->make();

            $dockerCompose = str_replace("{{{$config}}}", $configValue, $dockerCompose);
        }

        // Remove empty lines...
        return preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $dockerCompose);
    }

    /**
     * Replace the Host environment variables in the app's .env file.
     *
     * @param string $environment
     * @param  array  $services
     * @return string
     */
    protected function buildServiceEnv(string $environment, array $services): string
    {
        foreach ($this->servicesEnv as $service => $envClass) {
            if (in_array($service, $services)) {
                /**
                 * @var MakerInterface $envMaker
                 */
                $envMaker = new $envClass($environment);
                $environment = $envMaker->make();
            }
        }

        return $environment;
    }
}
