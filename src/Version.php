<?php
declare(strict_types=1);

namespace Histel\LumenSail;
use Composer\InstalledVersions;
use Exception;

class Version
{
    /**
     * Laravel/sail version => api version
     *
     * @var array|string[]
     */
    private array $versions = [
        '1.19.0' => 'V1',
        '1.26.0' => 'V2'
    ];

    /**
     * Get actual local version.
     * @return string
     * @throws Exception
     */
    public function getActual(): string
    {
        foreach ($this->versions as $version => $localVersion) {
            if (version_compare(InstalledVersions::getVersion('laravel/sail'), $version) <= 0) {
                return $localVersion;
            }
        }

        throw new Exception('Unknown version.');
    }
}