<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>請假系統 DEMO</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        @include('layouts.head_css')
      
    </head>
    <body class="hold-transition skin-blue-light sidebar-mini">
        <div class="wrapper">
            @include('layouts.header')
            
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                @yield('content')
            </div>
            <!-- /.content-wrapper -->

            @include('layouts.footer')
        </div>
        <!-- ./wrapper -->
    </body>
</html>
