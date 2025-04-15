<?php
namespace Odat\LaravelLens\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RunArtisanCommand implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $command;

    public function __construct(string $command)
    {
        $this->command = $command;
    }

    public function handle()
    {
        Artisan::call($this->command);
    }
}