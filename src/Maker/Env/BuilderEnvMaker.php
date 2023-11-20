<?php
declare(strict_types=1);

namespace Histel\LumenSail\Maker\Env;

final class BuilderEnvMaker
{
    /**
     * .env file content to string.
     *
     * @var string
     */
    private string $env;

    public function setEnv(string $env): self
    {
        $this->env = $env;

        return $this;
    }

    /**
     * @param string $config
     * @return void
     */
    public function add(string $config): self
    {
        $this->env .= "\n$config";

        return $this;
    }

    /**
     * @param string $search
     * @param string $replace
     * @return void
     */
    public function replaceOrAdd(string $search, string $replace): self
    {
        if (str_contains($this->env, $replace)) {
            return;
        }

        if (!preg_match($search, $this->env)) {
            $this->add($replace);
            return;
        }

        $this->env = preg_replace($search, $replace, $this->env);

        return $this;
    }

    /**
     * Return .env.
     *
     * @return string
     */
    public function getEnv(): string
    {
        return $this->env;
    }
}