@extends('laravel-lens::layouts.simple.index')
@section('content')
    <h1 class="mt-4"></h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active"></li>
    </ol>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Background Tasks
        </div>
        <div class="card-body">
            <div id="output" class="mt-4 alert alert-info d-none"></div>
            <table id="" class="table table-bordered">
                <thead>
                <tr>
                    <th>Task</th>
                    <th>Description</th>
                    <th>Frequency</th>
                    <th>Last run</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($commands as $command)
                    <tr>
                        <td>{{ $command['command'] }}</td>
                        <td>{{ $command['description'] }}</td>
                        <td>{{ $command['frequency'] }}</td>
                        <td>{{ $command['last_run'] }}</td>
                        <td>
                            <button class="btn btn-primary run-command" data-command="{{ $command['command'] }}">
                                Run
                            </button>
                        </td>

                    </tr>
                @endforeach


                </tbody>
            </table>


        </div>
    </div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.run-command').forEach(button => {
    button.addEventListener('click', function () {
        const command = this.getAttribute('data-command');

        // Store original content to restore later
        const originalHtml = this.innerHTML;

        // Disable button, show spinner, and gray background
        this.disabled = true;
        this.classList.add('btn-secondary');
        this.classList.remove('btn-primary'); // or whatever it was originally
        this.innerHTML = `
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Running...
        `;

        fetch("https://{{ request()->getHost() }}{{route('laravel-lens.run-command', [], false) }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ command })
        })
        .then(res => res.json())
        .then(data => {
            if(data.output == 0) {
                location.reload();

            }else{
                const output = document.getElementById('output');
                output.classList.remove('d-none');
                output.innerText = data.output;
            }
        })
        .catch(err => alert('Error: ' + err))
        .finally(() => {
            this.disabled = false;
            this.classList.remove('btn-secondary');
            this.classList.add('btn-primary');
            this.innerHTML = originalHtml;
        });;
    });
});
</script>
@endpush