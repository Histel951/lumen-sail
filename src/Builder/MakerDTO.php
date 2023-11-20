<?php
declare(strict_types=1);

namespace Histel\LumenSail\Builder;

use Histel\LumenSail\Maker\MakerInterface;

class MakerDTO
{
    /**
     * Maker for the build.
     *
     * @var MakerInterface
     */
    private MakerInterface $maker;

    /**
     * Maker name
     *
     * @var string
     */
    private string $name;

    public function __construct(string $name, MakerInterface $maker)
    {
        $this->name = $name;
        $this->maker = $maker;
    }

    /**
     * Get maker name
     *
     * @return void
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get maker.
     *
     * @return void
     */
    public function getMaker(): MakerInterface
    {
        return $this->maker;
    }
}