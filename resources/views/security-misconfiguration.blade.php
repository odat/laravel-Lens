@extends('laravel-lens::layouts.simple.index')
@section('content')
    <h1 class="mt-4">Security Misconfiguration</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">

            The application might be vulnerable if the application is:

            Missing appropriate security hardening across any part of the application stack or improperly configured permissions on cloud services.

            Unnecessary features are enabled or installed (e.g., unnecessary ports, services, pages, accounts, or privileges).

            Default accounts and their passwords are still enabled and unchanged.

            Error handling reveals stack traces or other overly informative error messages to users.

            For upgraded systems, the latest security features are disabled or not configured securely.

            The security settings in the application servers, application frameworks (e.g., Struts, Spring, ASP.NET), libraries, databases, etc., are not set to secure values.

            The server does not send security headers or directives, or they are not set to secure values.

            The software is out of date or vulnerable (see A06:2021-Vulnerable and Outdated Components).

            Without a concerted, repeatable application security configuration process, systems are at a higher risk.
        </li>
    </ol>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Security Misconfiguration
        </div>
        <div class="card-body">
            <table id="" class="table table-bordered">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Environment</td>
                    <td>{{config('app.env')}} <i class="fa fa-check" style="color:green;"></i></td>
                </tr>
                <tr>
                    <td>Debug</td>
                    <td>@if(config('app.debug') == 'On' && config('app.env') == 'production') On <i class="fa fa-times" style="color:red;"></i> @else Off  <i class="fa fa-check" style="color:darkgreen;"></i>@endif</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
