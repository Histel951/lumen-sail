<?php
declare(strict_types=1);

namespace Histel\LumenSail\Maker\Env;

class MailPitEnvMaker extends AbstractEnvMaker
{
    public function make(string $env = ''): string
    {
        $env = $this->builder->setEnv($env)
            ->replaceOrAdd('/^MAIL_HOST=(.*)/m', 'MAIL_HOST=mailpit');

        return $env->getEnv();
    }
}