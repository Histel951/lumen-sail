<?php
declare(strict_types=1);

namespace Histel\LumenSail\Builder\Docker;

use Histel\LumenSail\Builder\AbstractBuilder;
use Histel\LumenSail\Maker\Docker\DockerYmlDependsMaker;
use Histel\LumenSail\Maker\Docker\DockerYmlServicesMaker;
use Histel\LumenSail\Maker\Docker\DockerYmlVolumesMaker;

class DockerYmlReplaceBuilder extends AbstractBuilder
{
    /**
     * Latest version of laravel sail which this builder supports.
     * @var string
     */
    const LAST_VERSION = '1.19.0';

    /**
     * @var array
     */
    protected array $makersClasses = [
        'volumes' => DockerYmlVolumesMaker::class,
        'depends' => DockerYmlDependsMaker::class,
        'services' => DockerYmlServicesMaker::class,
    ];

    public function build(array $services): string
    {
        foreach ($this->makers as $makerDTO) {
            $configValue = $makerDTO->getMaker()->make($services);
            $this->config = str_replace("{{{$makerDTO->getName()}}}", $configValue, $this->config);
        }

        // Remove empty lines...
        return preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $this->config);
    }
}