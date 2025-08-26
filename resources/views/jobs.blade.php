@extends('laravel-lens::layouts.simple.index')

@section('content')
    <h1 class="mt-4"></h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active"></li>
    </ol>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-list me-1"></i>
            Queued Jobs
        </div>
        <div class="card-body">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Job</th>
                        <th>Queue</th>
                        <th>Attempts</th>
                        <th>Reserved At</th>
                        <th>Available At</th>
                        <th>Created At</th>
                        <th>Payload</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jobs as $job)
                        <tr>
                            <td>{{ $job['id'] }}</td>
                            <td>{{ $job['job'] }}</td>
                            <td>{{ $job['queue'] }}</td>
                            <td>{{ $job['attempts'] }}</td>
                            <td>{{ $job['reserved_at'] }}</td>
                            <td>{{ $job['available_at'] }}</td>
                            <td>{{ $job['created_at'] }}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-secondary" type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#pl-{{ $job['id'] }}">
                                    View
                                </button>
                            </td>
                        </tr>
                        <tr class="collapse" id="pl-{{ $job['id'] }}">
                            <td colspan="8">
                                <pre class="mb-0" style="white-space: pre-wrap;">{{ $job['payload'] }}</pre>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">No queued jobs found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
