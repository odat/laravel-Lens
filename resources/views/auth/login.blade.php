@extends('laravel-lens::layouts.simple.auth')
@section('content')


<div class="row justify-content-center">
    <div class="col-lg-5">
        <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
            <div class="card-body">
                <form action="{{ config('app.url') }}{{route('laravel-lens-auth.auth', [], false) }}" method="post">
                    @csrf
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputEmail" type="text" placeholder="Username" name="username" />
                        <label for="inputEmail">Username</label>
                        @error('username')
                            <span class="invalid-feedback" role="alert" style="display: block;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputPassword" type="password" placeholder="Password" name="password" />
                        <label for="inputPassword">Password</label>
                        @error('password')
                        <span class="invalid-feedback" role="alert" style="display: block;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">

                        <button class="btn btn-primary">Login</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

@endsection
