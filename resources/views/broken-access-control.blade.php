@extends('laravel-lens::layouts.simple.index')
@section('content')
    <h1 class="mt-4">Broken Access Control</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Moving up from the fifth position, 94% of applications were tested for some form of broken access control with the average incidence rate of 3.81%, and has the most occurrences in the contributed dataset with over 318k. Notable Common Weakness Enumerations (CWEs) included are CWE-200: Exposure of Sensitive Information to an Unauthorized Actor, CWE-201: Insertion of Sensitive Information Into Sent Data, and CWE-352: Cross-Site Request Forgery.</li>
    </ol>
    @include('laravel-lens::components.routes-table')
@endsection
