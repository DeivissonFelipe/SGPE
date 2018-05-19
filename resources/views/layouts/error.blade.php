<!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no' name='viewport'>
        <title>SGPE | @stack('tituloAba')</title>
    
        <!-- Bootstrap v3.3.7 -->
        <link href="{{ asset('/bower_components/bootstrap/dist/css/bootstrap.css') }}" rel="stylesheet" type="text/css" />
        <!-- CDN Bootstrap v3.3.7 -->
        <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous"> -->

        <!-- Font-Awesome v4.7.0 -->
        <link href="{{ asset('/bower_components/font-awesome/css/font-awesome.css') }}" rel="stylesheet" type="text/css" />
        <!-- CDN Font-Awesome v4.3.0 -->
        <!-- <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" /> -->

        <!-- AdminLte v2.4.2 -->
        <link href="{{ asset('/bower_components/admin-lte/dist/css/AdminLTE.min.css')}}" rel="stylesheet" type="text/css" />
    
        <!-- Theme Style -->
        <link href="{{ asset('css/skin-ufop.css')}}" rel="stylesheet" type="text/css"/> 
        @stack('css') 
        
    </head>
    <body class="hold-transition skin-ufop layout-top-nav sidebar-mini">
        <div class="wrapper">

            <header class="main-header">
                <nav class="navbar navbar-static-top">
                    <div class="container">
                        <div class="navbar-header">
                        @if(Auth::check())
                            <a href="{{ url('/') }}" class="navbar-brand"><b>SGPE</b></a>
                        @else
                            <a href="{{ url('/search') }}" class="navbar-brand"><b>SGPE</b></a>
                        @endif
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                                <i class="fa fa-bars"></i>
                            </button>
                        </div>
                    </div><!-- /.container -->
                </nav>
            </header>
        
            <div class="content-wrapper">
                <!-- Main content -->
                <section class="content">
                    @yield('content')
                </section><!-- end content -->
            </div><!-- end content-wrapper -->
            @include('layouts.footer')
        </div><!-- end wrapper -->


        <!-- REQUIRED JS SCRIPTS -->
        
        <!-- jQuery v3.2.1 -->
        <script src="{{ asset ('/bower_components/jquery/dist/jquery.js') }}" type="text/javascript"></script>
        
        <!-- CDN jQuery v3.2.1 -->
        <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
        
        <!-- Bootstrap v3.3.7 -->
        <script src="{{ asset ('/bower_components/bootstrap/dist/js/bootstrap.min.js') }}" type="text/javascript"></script>
        <!-- CDN Bootstrap v3.3.7 -->
        <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
    
    
        <!-- AdminLTE v2.4.0 -->
        <script src="{{ asset ('/bower_components/admin-lte/dist/js/adminlte.js') }}" type="text/javascript"></script>
        @stack('javascript')
    </body>
</html>