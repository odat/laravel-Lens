<?php

namespace Odat\LaravelLens\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Console\Command as ConsoleCommand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Odat\LaravelLens\Jobs\RunArtisanCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\BufferedOutput;

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
        foreach ($routesCollection as $route) {
            $middlewares = [];
            if (empty($route->middleware())) {
                $middlewares[] = 'Public';
            } else {
                foreach ($route->middleware() as $middleware) {
                    if ($middleware == 'Spatie\LaravelIgnition\Http\Middleware\RunnableSolutionsEnabled') {
                        $middlewares[] = 'Public';
                        continue;
                    }

                    if (strpos($middleware, 'auth:') !== false) {
                        $middlewares[] = 'Authenticated user';
                    } elseif ($middleware == 'web') {
                        $middlewares[] = 'Public';
                    } else {
                        $middlewares[] = $middleware;
                    }
                }
            }
            $routes[] = [
                'methods' => $route->methods()[0],
                'uri' => url($route->uri()),
                'name' => $route->getName(),
                'middlewares' => $middlewares
            ];
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
        foreach (self::$files as $file) {
            $fh = fopen($file, 'r');
            $i = 1;
            while ($line = fgets($fh)) {
                if (strpos($line, 'Raw(') !== false || strpos($line, 'raw(') !== false) {
                    $scannedFiles[] = ['path' => $file, 'line' => $i, 'code' => $line];
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

    public function listFolderFiles($dir)
    {
        $ffs = scandir($dir);

        unset($ffs[array_search('.', $ffs, true)]);
        unset($ffs[array_search('..', $ffs, true)]);

        // prevent empty ordered elements
        if (count($ffs) < 1)
            return;
        foreach ($ffs as $ff) {
            if (is_dir($dir . '/' . $ff)) {
                $this->listFolderFiles($dir . '/' . $ff);
            } else {
                self::$files[] = $dir . '/' . $ff;
            }
        }
    }

    public function commandsList(Request $request)
    {
        $lastRun = false;
        $lastRunFinished = false;
        $lastJobSucceeded = false;
        $background_logs_table = config('laravel-lens.background_logs_table.table');
        $taskNameColumn = config('laravel-lens.background_logs_table.task_name_column');
        if (Schema::hasTable($background_logs_table)) {
            $lastRunColumn = config('laravel-lens.background_logs_table.last_run_column');
            if (Schema::hasColumn($background_logs_table, $lastRunColumn)) {
                $lastRun = true;
            }

            $lastRunFinishedColumn = config('laravel-lens.background_logs_table.last_run_finished_column');
            if (Schema::hasColumn($background_logs_table, $lastRunFinishedColumn)) {
                $lastRunFinished = true;
            }

            $lastJobSucceededColumn = config('laravel-lens.background_logs_table.last_job_succeeded_column');
            if (Schema::hasColumn($background_logs_table, $lastJobSucceededColumn)) {
                $lastJobSucceeded = true;
            }
        }

        $registeredCommands = Artisan::all();
        $schedule = app(Schedule::class);
        require base_path('routes/console.php');

        $commands  = collect($schedule->events())->map(function ($event) use ($lastRun, $lastRunFinished, $lastJobSucceeded, $background_logs_table, $taskNameColumn, $lastRunColumn, $lastRunFinishedColumn, $registeredCommands, $lastJobSucceededColumn) {
            $command = $event->command;
            if ($command) {
                preg_match("/artisan(?:'|\\s)+([^']+)/", $command, $matches);
                $command = $matches[1] ?? $command;
            }

            $lastRunCommand = '';
            $lastRunFinishedCommand = '';
            $isSuccess = null;
            $button = true;

            if ($lastRun) {
                $getRow = DB::table($background_logs_table)->where($taskNameColumn, $command)->first();
                if ($getRow) {
                    $lastRunCommand = $getRow->$lastRunColumn;

                    if ($lastJobSucceeded) {
                        $isSuccess = $getRow->$lastJobSucceededColumn;
                    }


                    if ($lastRunFinished) {
                        if ($getRow->$lastRunFinishedColumn > $lastRunCommand) {
                            $lastRunFinishedCommand = $getRow->$lastRunFinishedColumn;
                        } else {
                            $lastRunFinishedCommand = '<div class="spinner waiting-job-finished" data-command="' . $command . '"></div>';
                            $button = false;
                        }
                    }
                }
            }



            $description = $event->description;
            if (!$description && isset($registeredCommands[$command])) {
                $description = $registeredCommands[$command]->getDescription() ?? '—';
            }

            return [
                'command' => $command,
                'frequency' => $this->translateCron($event->expression),
                'expression' => $event->expression,
                'last_run' => $lastRunCommand,
                'last_run_finished' => $lastRunFinishedCommand,
                'last_job_succeeded' => $isSuccess,
                'description' => $description,
                'button' => $button
            ];
        });


        $commands = $commands->unique('command')->sortBy('command')->values();

        return view('laravel-lens::commands', compact('commands'));
    }

    protected function translateCron(string $cron): string
    {
        return match ($cron) {
            '* * * * *'              => 'Every minute',
            '*/5 * * * *'            => 'Every 5 minutes',
            '*/30 * * * *'           => 'Every 30 minutes',
            '0 * * * *'              => 'Hourly',
            '30 * * * *'             => 'Hourly at minute 30',
            '55 * * * *'             => 'Hourly at minute 55',
            '0 */2 * * *'            => 'Every 2 hours',
            '0 */6 * * *'            => 'Every 6 hours',
            '0 */12 * * *'           => 'Every 12 hours',

            '0 0 * * *'              => 'Daily at midnight',
            '15 0 * * *'             => 'Daily at 00:15',
            '10 0 1 * *'             => 'Monthly (1st at 00:10)',
            '0 1 * * *'              => 'Daily at 01:00',
            '30 1 * * *'             => 'Daily at 01:30',
            '0 2 * * *'              => 'Daily at 02:00',
            '30 7 * * *'             => 'Daily at 07:30',
            '35 7 * * *'             => 'Daily at 07:35',
            '0 8 * * *'              => 'Daily at 08:00',
            '5 8 * * *'              => 'Daily at 08:05',
            '0 20 * * *'             => 'Daily at 20:00',
            '0 21 * * *'             => 'Daily at 21:00',
            '0 0 1 * *'              => 'Monthly (1st at midnight)',

            '0 0 1 12,3,6,9 *'       => 'Quarterly (1st of Mar, Jun, Sep, Dec at midnight)',

            default                  => 'Cron: ' . $cron,
        };
    }

    public function runCommand(Request $request)
    {
        set_time_limit(300);

        $request->validate([
            'command' => 'required|string',
        ]);

        try {
            $background_logs_table = config('laravel-lens.background_logs_table.table');
            $taskNameColumn = config('laravel-lens.background_logs_table.task_name_column');

            if (Schema::hasTable($background_logs_table)) {
                $lastRunColumn = config('laravel-lens.background_logs_table.last_run_column');
                $lastRunFinishedColumn = config('laravel-lens.background_logs_table.last_run_finished_column');
                $lastJobSucceededColumn = config('laravel-lens.background_logs_table.last_job_succeeded_column');
                if (Schema::hasColumn($background_logs_table, $lastRunColumn)) {
                    DB::table($background_logs_table)->where($taskNameColumn, $request->command)->update([
                        $lastRunColumn => Carbon::now(),
                        $lastRunFinishedColumn => null,
                        $lastJobSucceededColumn => null
                    ]);
                }
            }

            RunArtisanCommand::dispatch($request->command);
            session()->flash('status', 'Command has been queued successfully.');
            return response()->json(['output' => 'Command has been queued successfully.']);
        } catch (\Exception $e) {
            session()->flash('status', 'Error: ' . $e->getMessage());
            return response()->json(['output' => "Error: " . $e->getMessage()], 500);
        }
    }

    public function checkCommand(Request $request)
    {
        set_time_limit(300);

        $request->validate([
            'command' => 'required|string',
        ]);

        try {
            $background_logs_table = config('laravel-lens.background_logs_table.table');
            $taskNameColumn = config('laravel-lens.background_logs_table.task_name_column');
            $lastRunColumn = config('laravel-lens.background_logs_table.last_run_column');
            $lastRunFinishedColumn = config('laravel-lens.background_logs_table.last_run_finished_column');

            if (Schema::hasTable($background_logs_table)) {
                if (Schema::hasColumn($background_logs_table, $lastRunColumn)) {
                    $getRow = DB::table($background_logs_table)->where($taskNameColumn, $request->command)->first();
                    if ($getRow) {
                        $lastRun        = Carbon::parse($getRow->$lastRunColumn);
                        $lastRunFinished = Carbon::parse($getRow->$lastRunFinishedColumn);

                        $finished = $lastRunFinished->greaterThanOrEqualTo($lastRun);
                        return response()->json(['finished' => (bool) $finished]);
                    }
                }
            }
        } catch (\Exception $e) {
            return false;
        }
    }
}
