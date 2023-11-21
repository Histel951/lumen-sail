<?php
declare(strict_types=1);

namespace Histel\LumenSail\Maker\Env;

use Histel\LumenSail\Maker\MakerInterface;

abstract class AbstractEnvMaker implements MakerInterface
{
    /**
     * Class for building env config.
     *
     * @var BuilderEnvMaker
     */
    protected BuilderEnvMaker $builder;

    public function __construct()
    {
        $this->builder = new BuilderEnvMaker();
    }

    abstract public function make(string $env = ''): string;
}