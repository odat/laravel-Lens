<?php

namespace Odat\LaravelLens\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class LaravelLensJobsController extends Controller
{
    public function jobsList(Request $request)
    {
        abort_unless(Schema::hasTable('jobs'), 404, 'jobs table not found.');

        $jobs = DB::table('jobs')
            ->select('id', 'queue', 'payload', 'attempts', 'reserved_at', 'available_at', 'created_at')
            ->orderByDesc('id')
            ->get()
            ->map(function ($row) {
                // Parse payload to get job class
                $displayName = null;
                try {
                    $payload = json_decode($row->payload, true, 512, JSON_THROW_ON_ERROR);
                    $displayName = $payload['displayName'] ?? ($payload['job'] ?? null);
                } catch (\Throwable $e) {
                    // ignore
                }

                // jobs table stores some timestamps as UNIX seconds; normalize
                $reservedAt  = $row->reserved_at ? Carbon::createFromTimestamp($row->reserved_at)->toDateTimeString() : '—';
                $availableAt = $row->available_at ? Carbon::createFromTimestamp($row->available_at)->toDateTimeString() : '—';
                $createdAt   = $row->created_at
                    ? (is_numeric($row->created_at)
                        ? Carbon::createFromTimestamp($row->created_at)->toDateTimeString()
                        : Carbon::parse($row->created_at)->toDateTimeString())
                    : '—';

                return [
                    'id'           => $row->id,
                    'job'          => $displayName ?: '—',
                    'queue'        => $row->queue ?: 'default',
                    'attempts'     => $row->attempts,
                    'reserved_at'  => $reservedAt,
                    'available_at' => $availableAt,
                    'created_at'   => $createdAt,
                    'payload'      => $row->payload,
                ];
            });

        return view('laravel-lens::jobs', compact('jobs'));
    }


    public function failedJobList(Request $request)
    {
        abort_unless(Schema::hasTable('failed_jobs'), 404, 'failed_jobs table not found.');

        $failed = DB::table('failed_jobs')
            ->select('id', 'uuid', 'connection', 'queue', 'payload', 'exception', 'failed_at')
            ->orderByDesc('failed_at')
            ->get()
            ->map(function ($row) {
                // Try to extract job class from payload
                $displayName = null;
                try {
                    $payload = json_decode($row->payload, true, 512, JSON_THROW_ON_ERROR);
                    $displayName = $payload['displayName'] ?? ($payload['job'] ?? null);
                } catch (\Throwable $e) {
                    // ignore decode errors
                }

                // First line of exception for compact display
                $errorFirstLine = strtok((string) $row->exception, "\n");

                return [
                    'id'           => $row->id,
                    'uuid'         => $row->uuid ?? '',
                    'job'          => $displayName ?: '—',
                    'connection'   => $row->connection,
                    'queue'        => $row->queue,
                    'failed_at'    => $row->failed_at ? Carbon::parse($row->failed_at)->toDateTimeString() : '—',
                    'exception'    => $row->exception,
                    'error_first'  => $errorFirstLine,
                ];
            });

        return view('laravel-lens::failed_jobs', compact('failed'));
    }
}
