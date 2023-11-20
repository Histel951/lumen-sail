<?php
declare(strict_types=1);

namespace Histel\LumenSail\Maker\Docker;

use Histel\LumenSail\Maker\MakerInterface;

abstract class AbstractDockerMaker implements MakerInterface
{
    /**
     * Services that can be used to make the config.
     *
     * @var array
     */
    protected array $usesServices = [];

    /**
     * Make docker-compose.yml.
     *
     * @param array $services services that the user selected for the build
     * @return  string
     */
    abstract public function make(array $services = []): string;
}