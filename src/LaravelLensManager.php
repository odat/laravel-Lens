<?php
namespace Odat\LaravelLens;

use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Support\Manager;
use Odat\LaravelLens\Drivers\Simple\LaravelLens;
class LaravelLensManager extends Manager
{
    public function getDefaultDriver()
    {
        $defaultDriverName = $this->config->get('laravel-lens.default');
        $defaultDriver = $this->config->get('laravel-lens.drivers.' . $defaultDriverName . '.driver');
        return $defaultDriver;
    }

    public function createSimpleDriver()
    {
        return new LaravelLens();
    }
}
