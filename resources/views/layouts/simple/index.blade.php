<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="Moath Odat" />
    <title>Dashboard - Laravel Lens</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="{{asset('vendor/laravel-lens/css/styles.css')}}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="{{config('laravel-lens.route-prefix')}}">Laravel Lens</a>
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    <!-- Navbar Search-->
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        <div class="input-group">

        </div>
    </form>
    <!-- Navbar-->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><hr class="dropdown-divider" /></li>
                <li><a class="dropdown-item" href="{{route('laravel-lens-auth.logout')}}">Logout</a></li>
            </ul>
        </li>
    </ul>
</nav>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading">Core</div>
                    <a class="nav-link" href="{{config('laravel-lens.route-prefix')}}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>
                    <div class="sb-sidenav-menu-heading">OWASP Top Ten</div>
                    <a class="nav-link" href="{{route('laravel-lens.broken-access-control')}}">Broken Access Control</a>
                    <a class="nav-link" href="{{route('laravel-lens.cryptographic-failures')}}">Cryptographic Failures</a>
                    <a class="nav-link" href="{{route('laravel-lens.injection')}}">Injection</a>
                    <a class="nav-link" href="{{route('laravel-lens.insecure-design')}}">Insecure Design</a>
                    <a class="nav-link" href="{{route('laravel-lens.security-misconfiguration')}}">Security Misconfiguration</a>
                    <a class="nav-link" href="{{route('laravel-lens.vulnerable-and-outdated-components')}}">Vulnerable and Outdated Components</a>
                    <a class="nav-link" href="{{route('laravel-lens.identification-and-authentication-failures')}}">Identification and Authentication Failures</a>
                    <a class="nav-link" href="{{route('laravel-lens.software-and-data-integrity-failures')}}">Software and Data Integrity Failures</a>
                    <a class="nav-link" href="{{route('laravel-lens.security-logging-and-monitoring-failures')}}">Security Logging and Monitoring Failures</a>
                    <a class="nav-link" href="{{route('laravel-lens.server-side-request-forgery')}}">Server-Side Request Forgery</a>

                </div>
            </div>
            <div class="sb-sidenav-footer">

            </div>
        </nav>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                @yield('content')
            </div>
        </main>
        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                </div>
            </div>
        </footer>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="{{asset('vendor/laravel-lens/js/scripts.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="{{asset('vendor/laravel-lens/assets/demo/chart-area-demo.js')}}"></script>
<script src="{{asset('vendor/laravel-lens/assets/demo/chart-bar-demo.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="{{asset('vendor/laravel-lens/js/datatables-simple-demo.js')}}"></script>
</body>
</html>
