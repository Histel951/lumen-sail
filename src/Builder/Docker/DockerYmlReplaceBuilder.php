<?php
declare(strict_types=1);

namespace Histel\LumenSail\Builder\Docker;

use Histel\LumenSail\Builder\BuilderInterface;
use Histel\LumenSail\Maker\Docker\DockerYmlDependsMaker;
use Histel\LumenSail\Maker\Docker\DockerYmlServicesMaker;
use Histel\LumenSail\Maker\Docker\DockerYmlVolumesMaker;
use Histel\LumenSail\Maker\MakerInterface;

class DockerYmlReplaceBuilder implements BuilderInterface
{
    /**
     * Latest version of laravel sail which this builder supports.
     * @var string
     */
    const LAST_VERSION = '1.19.0';

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
     * Yml config template.
     * @var string
     */
    private string $dockerYmlConfig;

    public function __construct(string $dockerYmlConfig)
    {
        $this->dockerYmlConfig = $dockerYmlConfig;
    }

    public function build(array $services): string
    {
        foreach ($this->serviceDocker as $config => $item) {
            /**
             * @var MakerInterface $dockerYmlMaker
             */
            $dockerYmlMaker = new $item['class']($services, $item['services']);
            $configValue = $dockerYmlMaker->make();

            $this->dockerYmlConfig = str_replace("{{{$config}}}", $configValue, $this->dockerYmlConfig);
        }

        // Remove empty lines...
        return preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $this->dockerYmlConfig);
    }
}