<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - LMS SD</title>

    {{-- AdminLTE CSS --}}
    <link rel="stylesheet" href="{{ asset('lte/dist/css/adminlte.min.css') }}">
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="{{ asset('lte/plugins/fontawesome-free/css/all.min.css') }}">
    {{-- Google Font (Opsional) --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700">

    @stack('styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        {{-- Navbar --}}
        @include('layouts.components.navbar')

        {{-- Sidebar --}}
        @include('layouts.components.sidebar')


        {{-- Content Wrapper --}}
        <div class="content-wrapper">
            <section class="content p-3">
                @yield('content')
            </section>
        </div>

        {{-- Footer --}}
        <footer class="main-footer text-sm text-center">
            <strong>&copy; {{ date('Y') }} LMS SD.</strong> All rights reserved.
        </footer>
    </div>

    {{-- AdminLTE JS --}}
    <script src="{{ asset('lte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('lte/dist/js/adminlte.min.js') }}"></script>

    @stack('scripts')
</body>

</html>
