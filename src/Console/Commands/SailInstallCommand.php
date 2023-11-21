<?php

namespace Histel\LumenSail\Console\Commands;

use Exception;
use Histel\LumenSail\Builder\BuilderFactory;
use Histel\LumenSail\Builder\BuilderInterface;
use Histel\LumenSail\Console\InteractsWithDockerComposeServices;
use Illuminate\Console\Command;

class SailInstallCommand extends Command
{
    use InteractsWithDockerComposeServices;

    protected array $signatureVersion = [
        'V1' => 'sail:install {--with= : The services that should be included in the installation}',
        'V2' => 'sail:install
                {--with= : The services that should be included in the installation}
                {--devcontainer : Create a .devcontainer configuration directory}'
    ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sail:install {--with= : The services that should be included in the installation}';

    /**
     * @throws Exception
     */
    public function __construct()
    {
        parent::__construct();

        $this->signature = $this->signatureVersion[$this->version()];
    }

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
     * @throws Exception
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
        $this->configurePhpUnit();

        if ($this->option('devcontainer')) {
            $this->installDevContainer();
        }

        $this->info('Sail scaffolding installed successfully.');
    }

    /**
     * Receive env config.
     *
     * @return string
     */
    private function receiveEnv(): string
    {
        $env = file_get_contents($this->laravel->basePath('.env'));
        if (!preg_match('/^COMPOSE_PROJECT_NAME=(.*)/m', $env)) {
            $composeProjectName = $this->ask('Write the composer project name:');
            $env .= "\nCOMPOSE_PROJECT_NAME=$composeProjectName\n";
        }

        return $env;
    }

    /**
     * Select services.
     *
     * @return array|string[]
     * @throws Exception
     */
    private function receiveServices(): array
    {
        if ($this->option('with')) {
            $services = $this->option('with') == 'none' ? [] : explode(',', $this->option('with'));
        } elseif ($this->option('no-interaction')) {
            $services = $this->getDefaultServices();
        } else {
            $services = $this->choice(
                'Which services would you like to install?',
                $this->getServices(), 0, null, true);
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
