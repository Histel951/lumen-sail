<?php
declare(strict_types=1);

namespace Histel\LumenSail\Maker\Docker;

class DockerYmlDependsMaker extends AbstractDockerMaker
{
    public function make(): string
    {
        $depends =  collect($this->services)
            ->filter(function ($service) {
                return in_array($service, $this->usesServices);
            })->map(function ($service) {
                return "            - $service";
            })->whenNotEmpty(function ($collection) {
                return $collection->prepend('depends_on:');
            })->implode("\n");

        return empty($depends) ? '' : '        '.$depends;
    }
}