<?php
declare(strict_types=1);

namespace Histel\LumenSail\Maker\Docker;

use Histel\LumenSail\Maker\MakerInterface;

abstract class AbstractDockerMaker implements MakerInterface
{
    protected array $services;

    public function __construct(array $services)
    {
        $this->services = $services;
    }
}