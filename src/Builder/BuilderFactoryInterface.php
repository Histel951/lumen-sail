<?php
declare(strict_types=1);

namespace Histel\LumenSail\Builder;

interface BuilderFactoryInterface
{
    /**
     * Returns the current docker.yml builder implementation for the installed version "laravel/sail".
     *
     * @param string $config
     * @return BuilderInterface
     */
    public function dockerYml(string $config): BuilderInterface;

    /**
     * Returns the current .env builder implementation for the installed version "laravel/sail".
     *
     * @param string $config
     * @return BuilderInterface
     */
    public function env(string $config): BuilderInterface;
}