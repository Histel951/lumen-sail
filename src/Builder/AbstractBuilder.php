<?php
namespace Histel\LumenSail\Builder;

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
     * @var string
     */
    protected string $config;

    public function __construct(string $config)
    {
        $this->config = $config;

        foreach ($this->makersClasses as $serviceName => $class) {
            $this->makers[] = new MakerDTO($serviceName, new $class);
        }
    }
}