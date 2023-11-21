<?php
namespace Histel\LumenSail\Maker;

interface MakerInterface
{
    /**
     * Make config depending on the transferred services.
     *
     * @return string|array
     */
    public function make();
}