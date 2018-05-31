<!DOCTYPE html>
<html>
  <head>
      <meta charset="UTF-8">
      <title>SGPE | Home</title>
      <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
  
      <!-- Bootstrap v3.3.7 -->
      <link href="{{ asset('/bower_components/bootstrap/dist/css/bootstrap.css') }}" rel="stylesheet" type="text/css" />
      <!-- CDN Bootstrap v3.3.7 -->
      <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous"> -->

      <!-- Font-Awesome v4.7.0 -->
      <link href="{{ asset('/bower_components/font-awesome/css/font-awesome.css') }}" rel="stylesheet" type="text/css" />
      <!-- CDN Font-Awesome v4.3.0 -->
      <!-- <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" /> -->

      <!-- Ionicons v2.0.0-->
      <link href="{{ asset('/bower_components/Ionicons/css/ionicons.css') }}" rel="stylesheet" type="text/css" />
      <!-- CDN Ionicons v2.0.0-->
      <!-- <link href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" /> -->

      <!-- AdminLte v2.4.2 -->
      <link href="{{ asset('/bower_components/admin-lte/dist/css/AdminLTE.min.css')}}" rel="stylesheet" type="text/css" />
  
      <!-- Theme Style -->
      <link href="{{ asset('css/skin-ufop.css')}}" rel="stylesheet" type="text/css"/> 
      <link href="{{ asset('css/ufop.css') }}" rel="stylesheet">

      <!-- iCheck v1.0.1-->
      <link href="{{ asset('/bower_components/admin-lte/plugins/iCheck/square/blue.css')}}" rel="stylesheet" type="text/css" />
      <style>
        .help-block{
          color:red;
        }
      </style>
  </head>
  <body class="hold-transition login-page">

      <div class="login-box ">
          <div class="login-logo">
            <a href="../../index2.html"><b>S</b>istema de <b>G</b>erenciamento de <b>P</b>lano de <b>E</b>nsino</a>
          </div><!-- end login-logo -->

          <div class="login-box-body with-border ufop-border">
              <p class="login-box-msg">Digite seu login e senha para acessar o sistema</p>
              <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                  {{ csrf_field() }}

                  <div class="form-group has-feedback">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    <input type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}" required autofocus>
                    @if ($errors->has('email'))
                      <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                      </span>
                    @endif
                  </div><!-- end form-group has-feedback -->

                  <div class="form-group has-feedback">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    <input type="password" class="form-control" placeholder="Senha da Minha Ufop" name="password" required>
                    @if ($errors->has('password'))
                      <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                      </span>
                    @endif
                  </div><!-- end form-group has-feedback -->

                  <div class="row">
                    <div class="col-xs-8">
                      <div class="checkbox icheck">
                        <label><input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me</label>
                      </div><!-- end checkbox icheck -->
                    </div><!-- end col-xs-8 -->

                    <div class="col-xs-4">
                      <button type="submit" class="btn btn-ufop btn-block btn-flat">Entrar</button>
                    </div><!-- end col-xs-4 -->
                  </div><!-- end row -->
              </form>
          </div><!-- end login-box-body -->
      </div><!-- end login-box -->

      <!-- REQUIRED JS SCRIPTS -->
      
      <!-- jQuery v3.2.1 -->
      <script src="{{ asset ('/bower_components/jquery/dist/jquery.min.js') }}"></script>
      <!-- CDN jQuery v3.2.1 -->
      <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
      
      <!-- Bootstrap v3.3.7 -->
      <script src="{{ asset ('/bower_components/bootstrap/dist/js/bootstrap.min.js') }}" type="text/javascript"></script>
      <!-- CDN Bootstrap v3.3.7 -->
      <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
  
      <!-- iCheck v1.0.1-->
      <script src="{{ asset ('/bower_components/admin-lte/plugins/iCheck/icheck.min.js')}}"></script>

      <script>
        $(function () {
          $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
          });
        });
      </script>
  </body>
</html>