<?php
declare(strict_types=1);

namespace Histel\LumenSail\Builder\Docker;

use Histel\LumenSail\Builder\AbstractBuilder;
use Histel\LumenSail\Maker\Docker\V2\DockerYmlDependsMaker;
use Histel\LumenSail\Maker\Docker\V2\DockerYmlServicesMaker;
use Histel\LumenSail\Maker\Docker\V2\DockerYmlVolumesMaker;
use Symfony\Component\Yaml\Yaml;

class DockerYmlStubsBuilder extends AbstractBuilder
{
    /**
     * @var string[]
     */
    protected array $makersClasses = [
        'volumes' => DockerYmlVolumesMaker::class,
        'depends' => DockerYmlDependsMaker::class,
        'services' => DockerYmlServicesMaker::class,
    ];

    public function build(array $services): string
    {
        $this->config = $this->getMaker('depends')->make($services, $this->config);
        $this->config = $this->getMaker('services')->make($services, $this->config);
        $this->config = $this->getMaker('volumes')->make($services, $this->config);

        return Yaml::dump($this->config, Yaml::DUMP_OBJECT_AS_MAP);
    }
}