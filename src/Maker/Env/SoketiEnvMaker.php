<?php
declare(strict_types=1);

namespace Histel\LumenSail\Maker\Env;

class SoketiEnvMaker extends AbstractEnvMaker
{
    public function make(string $env = ''): string
    {
        $env = $this->builder->setEnv($env)
            ->replaceOrAdd('/^BROADCAST_DRIVER=(.*)/m', "BROADCAST_DRIVER=pusher")
            ->replaceOrAdd('/^PUSHER_APP_ID=(.*)/m', "PUSHER_APP_ID=app-id")
            ->replaceOrAdd('/^PUSHER_APP_KEY=(.*)/m', "PUSHER_APP_KEY=app-key")
            ->replaceOrAdd('/^PUSHER_APP_SECRET=(.*)/m', "PUSHER_APP_SECRET=app-secret")
            ->replaceOrAdd('/^PUSHER_HOST=(.*)/m', "PUSHER_HOST=soketi")
            ->replaceOrAdd('/^PUSHER_PORT=(.*)/m', "PUSHER_PORT=6001")
            ->replaceOrAdd('/^PUSHER_SCHEME=(.*)/m', "PUSHER_SCHEME=http")
            ->replaceOrAdd('/^VITE_PUSHER_HOST=(.*)/m', "VITE_PUSHER_HOST=localhost");

        return $env->getEnv();
    }
}