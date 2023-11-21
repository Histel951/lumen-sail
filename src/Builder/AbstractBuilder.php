<?php
namespace Histel\LumenSail\Builder;

use Histel\LumenSail\Maker\MakerInterface;

abstract class AbstractBuilder implements BuilderInterface
{
    /**
     * List of initialized makers for the build.
     *
     * @var MakerDTO[]
     */
    protected array $makers;

    /**
     * The classes and dependencies for build.
     *
     * @var array
     */
    protected array $makersClasses = [];

    /**
     * Yml config template.
     *
     * @var string|array
     */
    protected $config;

    public function __construct($config)
    {
        $this->config = $config;

        foreach ($this->makersClasses as $serviceName => $class) {
            $this->makers[$serviceName] = new MakerDTO($serviceName, new $class);
        }
    }

    /**
     * Get maker by name.
     *
     * @param string $name
     * @return MakerInterface
     */
    protected function getMaker(string $name): MakerInterface
    {
        return $this->makers[$name]->getMaker();
    }
}