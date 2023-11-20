<?php
namespace Histel\LumenSail\Maker;

interface MakerInterface
{
    /**
     * Make config depending on the transferred services.
     *
     * @return string
     */
    public function make(): string;
}