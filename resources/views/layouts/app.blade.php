<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Managemen Gudang</title>



    @stack('prepand-style')
    @include('layouts.partials.style')
    @stack('addon-style')

    <link rel="shortcut icon" href="images/favicon.png" />
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('layouts.partials.navbar')
        {{-- <div class="container-fluid page-body-wrapper"> --}}
        @include('layouts.partials.sidebar')
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            @include('layouts.partials.header')
            <!-- /.content-header -->
            <div class="content">
                <div class="container-fluid">

                    @yield('content')

                </div>
            </div>
            <!-- content ends -->
        </div>
        <!-- content-wrapper ends -->
        @include('layouts.partials.footer')
    </div>
    <!-- wrapper -->

    @stack('prepand-script')
    @include('layouts.partials.script')
    @stack('addon-script')
</body>
</html>
