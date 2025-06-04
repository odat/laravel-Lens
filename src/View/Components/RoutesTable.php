<?php

namespace Odat\LaravelLens\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class RoutesTable extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $routeCollection = Route::getRoutes();
        dd($routeCollection);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $routeCollection = Route::getRoutes();
        dd($routeCollection);
        return view('laravel-lens::components.routes-table', ['routes' => $routeCollection]);
    }
}
