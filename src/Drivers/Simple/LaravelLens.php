<?php

namespace Odat\LaravelLens\Drivers\Simple;

use Odat\LaravelLens\LaravelLens as LaravelLensBase;
class LaravelLens extends LaravelLensBase
{
    public function index()
    {
        return view('laravel-lens::index');
    }
}
