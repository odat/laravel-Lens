@extends('laravel-lens::layouts.simple.index')

@section('content')
    <h1 class="mt-4"></h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active"></li>
    </ol>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-exclamation-triangle me-1"></i>
            Failed Jobs
        </div>
        <div class="card-body">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>UUID</th>
                        <th>Job</th>
                        <th>Queue</th>
                        <th>Connection</th>
                        <th>Failed At</th>
                        <th>Error</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($failed as $job)
                        <tr>
                            <td>{{ $job['id'] }}</td>
                            <td class="text-muted" style="max-width: 220px; word-break: break-all;">{{ $job['uuid'] }}</td>
                            <td>{{ $job['job'] }}</td>
                            <td>{{ $job['queue'] }}</td>
                            <td>{{ $job['connection'] }}</td>
                            <td>{{ $job['failed_at'] }}</td>
                            <td style="max-width: 380px; word-break: break-word;">{{ $job['error_first'] }}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-secondary" type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#ex-{{ $job['id'] }}"
                                        aria-expanded="false">
                                    View
                                </button>
                            </td>
                        </tr>
                        <tr class="collapse" id="ex-{{ $job['id'] }}">
                            <td colspan="8">
                                <pre class="mb-0" style="white-space: pre-wrap;">{{ $job['exception'] }}</pre>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">No failed jobs found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
