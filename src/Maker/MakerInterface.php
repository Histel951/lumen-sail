<?php
namespace Histel\LumenSail\Env;

interface EnvMaker
{
    public function make(): string;
}