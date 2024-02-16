<?php

namespace Odat\LaravelLens\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class LaravelLensController extends Controller
{
    public static $files;
    public function index(Request $request)
    {

        $routeCollection = Route::getRoutes();
        return view('laravel-lens::index', ['routes' => $routeCollection]);
    }

    public function brokenAccessControl(Request $request)
    {
        $routesCollection = Route::getRoutes();
        $routes = [];
        foreach($routesCollection as $route) {
            $middlewares = [];
            if(empty($route->middleware())) {
                $middlewares[] = 'Public';
            }else{
                foreach( $route->middleware() as $middleware) {
                    if($middleware == 'Spatie\LaravelIgnition\Http\Middleware\RunnableSolutionsEnabled') {
                        $middlewares[] = 'Public';
                        continue;
                    }

                    if(strpos($middleware, 'auth:') !== false) {
                        $middlewares[] = 'Authenticated user';
                    }elseif($middleware == 'web') {
                        $middlewares[] = 'Public';
                    }else{
                        $middlewares[] = $middleware;
                    }
                }
            }
            $routes[] = ['methods' => $route->methods()[0],
                'uri' => url($route->uri()),
                'name' => $route->getName(),
                'middlewares' => $middlewares];
        }
        $routes = array_reverse($routes);
        return view('laravel-lens::broken-access-control', ['routes' => $routes]);
    }

    public function cryptographicFailures(Request $request)
    {
        return view('laravel-lens::cryptographic-failures', []);
    }

    public function injection(Request $request)
    {
        $dir = app_path();
        $this->listFolderFiles($dir);
        $scannedFiles = [];
        foreach(self::$files as $file) {
            $fh = fopen($file,'r');
            $i = 1;
            while ($line = fgets($fh)) {
                if(strpos($line, 'Raw(') !== false || strpos($line, 'raw(') !== false) {
                    $scannedFiles[] = ['path' => $file, 'line' =>$i, 'code' => $line];
                }
                $i++;
            }
            fclose($fh);
        }


        return view('laravel-lens::injection', ['files' => $scannedFiles]);
    }

    public function insecureDesign(Request $request)
    {
        return view('laravel-lens::insecure-design', []);
    }

    public function securityMisconfiguration(Request $request)
    {
        return view('laravel-lens::security-misconfiguration', []);
    }

    public function vulnerableAndOutdatedComponents(Request $request)
    {
        return view('laravel-lens::vulnerable-and-outdated-components', []);
    }

    public function identificationAndAuthenticationFailures(Request $request)
    {
        return view('laravel-lens::identification-and-authentication-failures', []);
    }

    public function softwareAndDataIntegrityFailures(Request $request)
    {
        return view('laravel-lens::software-and-data-integrity-failures', []);
    }

    public function securityLoggingAndMonitoringFailures(Request $request)
    {
        return view('laravel-lens::security-logging-and-monitoring-failures', []);
    }

    public function serverSideRequestForgery(Request $request)
    {
        return view('laravel-lens::server-side-request-forgery', []);
    }

    public function listFolderFiles($dir){
        $ffs = scandir($dir);

        unset($ffs[array_search('.', $ffs, true)]);
        unset($ffs[array_search('..', $ffs, true)]);

        // prevent empty ordered elements
        if (count($ffs) < 1)
            return;
        foreach($ffs as $ff){
            if(is_dir($dir.'/'.$ff)) {
                $this->listFolderFiles($dir . '/' . $ff);
            }else{
                self::$files[] = $dir.'/'.$ff;
            }
        }
    }
}
