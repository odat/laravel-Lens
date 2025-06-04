@extends('laravel-lens::layouts.simple.index')
@section('content')
    <h1 class="mt-4">Injection</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">
            Injection slides down to the third position. 94% of the applications were tested for some form of injection with a max incidence rate of 19%, an average incidence rate of 3%, and 274k occurrences. Notable Common Weakness Enumerations (CWEs) included are CWE-79: Cross-site Scripting, CWE-89: SQL Injection, and CWE-73: External Control of File Name or Path.
        </li>
    </ol>


    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Injection
        </div>
        <div class="card-body">
            <table id="" class="table table-bordered">
                <thead>
                <tr>
                    <th>File</th>
                    <th>Line</th>
                    <th>Code</th>
                </tr>
                </thead>
                <tbody>
                @foreach($files as $file)
                    <tr>
                        <td>{{$file['path']}}</td>
                        <td>{{$file['line']}}</td>
                        <td><pre>{{ ltrim($file['code'])}}</pre></td>
                    </tr>

                @endforeach


                </tbody>
            </table>
        </div>
    </div>

@endsection


