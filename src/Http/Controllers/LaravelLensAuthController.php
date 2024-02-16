<?php

namespace Odat\LaravelLens\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class LaravelLensAuthController extends Controller
{
    public function login(Request $request)
    {

        $routeCollection = Route::getRoutes();
        return view('laravel-lens::auth.login', ['routes' => $routeCollection]);
    }

    public function auth(Request $request)
    {
        $request->validate(['username' => 'required',
            'password' => 'required']);

        $username = $request->get('username');
        $password = $request->get('password');
        $sessionName = config('laravel-lens.session_name');
        if($username === config('laravel-lens.username') && $password === config('laravel-lens.password')) {
            session()->put($sessionName, Carbon::now()->timestamp);
        }else{
            throw ValidationException::withMessages(['username' => 'Invalid username or password.']);
        }

        return redirect()->route('laravel-lens.index');
    }

    public function logout(Request $request)
    {
        $sessionName = config('laravel-lens.session_name');
        session()->forget( $sessionName);
        return redirect()->route('laravel-lens-auth.login');
    }
}
