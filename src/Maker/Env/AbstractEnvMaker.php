<?php
namespace Histel\LumenSail\Maker\Env;

use Histel\LumenSail\Maker\MakerInterface;

abstract class AbstractEnvMaker implements MakerInterface
{
    /**
     * @var string
     */
    protected string $env;

    public function __construct(string $env)
    {
        $this->env = $env;
    }

    /**
     * @param string $config
     * @return void
     */
    protected function add(string $config): void
    {
        $this->env .= "\n$config";
    }

    /**
     * @param string $search
     * @param string $replace
     * @return void
     */
    protected function replaceOrAdd(string $search, string $replace): void
    {
        if (str_contains($this->env, $replace)) {
            return;
        }

        if (!str_contains($this->env, $search)) {
            $this->add($replace);
            return;
        }

        $this->env = str_replace($search, $replace, $this->env);
    }
}