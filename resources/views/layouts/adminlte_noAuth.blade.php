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
        <link href="{{ asset('css/ufop.css') }}" rel="stylesheet">
        
        @stack('css') 
        
    </head>
    <body class="hold-transition skin-ufop layout-top-nav sidebar-mini">
        <div class="wrapper">

            <header class="main-header">
                <nav class="navbar navbar-static-top">
                    <div class="container">
                        <div class="navbar-header">
                        <a href="{{ url('/search') }}" class="navbar-brand"><b>SGPE</b></a>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                            <i class="fa fa-bars"></i>
                        </button>
                        </div>

                        
                        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                            <form class="navbar-form navbar-left" role="search" method="post" action="/search">
                                {{ csrf_field() }}
                                <div class="form-group">    
                                    <input type="text" class="form-control" id="navbar-search-input" name="busca">
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-default" type="submit"><i class="fa fa-search" aria-hidden="true"></i> Buscar</button>
                                </div>
                            </form>
                        </div>
                    </div><!-- /.container -->
                </nav>
            </header>
        
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                   @yield('breadcrumb')
                </section>
                <!-- Main content -->
                <section class="content">
                    @if($errors->any())
                        <div class="alert alert-danger" id="errors">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true" aria-label="close">&times;</button>    
                            <ul>
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                            </ul>
                        </div><!-- end alert alert-danger -->
                    @endif

                    @if(Session::has('warnings'))
                        <div class="alert alert-warning warnings" id="warnings">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true" aria-label="close">&times;</button>
                            <ul>
                            @foreach(Session::get('warnings') as $in)    
                                <li>{{$in}}</li>
                            @endforeach
                            </ul>
                        </div><!-- end alert alert-warnings -->
                    @endif
                
                    @if(Session::has('error'))
                        <div class="alert alert-danger" id="alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true" aria-label="close">&times;</button>    
                            {{Session::get('error')}}
                        </div><!-- end alert alert-danger -->
                    @endif
                    @if(Session::has('info'))
                        <div class="alert alert-info" id="alert-info">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true" aria-label="close">&times;</button>
                            {{Session::get('info')}}
                        </div><!-- end alert alert-info -->
                    @endif
                    @if(Session::has('warning'))
                        <div class="alert alert-warning" id="alert-warning">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true" aria-label="close">&times;</button>
                            {{Session::get('warning')}}
                        </div><!-- end alert alert-warning -->
                    @endif
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
        
        <script type="text/javascript">
            $('div#alert-info').delay(3000).slideUp(300);
            $('div#alert-warning').delay(3000).slideUp(300);
            $('div#warnings').delay(10000).slideUp(500);
        </script>
        
        @stack('javascript')
    </body>
</html>