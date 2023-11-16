<?php
declare(strict_types=1);

namespace Histel\LumenSail\Maker\Docker;

use Histel\LumenSail\Maker\MakerInterface;

abstract class AbstractDockerMaker implements MakerInterface
{
    protected array $services;

    protected array $usesServices;

    public function __construct(array $services, array $usesServices)
    {
        $this->services = $services;
        $this->usesServices = $usesServices;
    }
}