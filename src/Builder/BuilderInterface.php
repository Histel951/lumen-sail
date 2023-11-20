<?php
declare(strict_types=1);

namespace Histel\LumenSail\Builder;

interface BuilderInterface
{
    /**
     * Build config depending on the transferred services.
     *
     * @param array $services
     * @return string
     */
    public function build(array $services): string;
}