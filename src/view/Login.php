<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>Fluxa | Login</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="lib/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="lib/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="lib/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/template/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="login"><b>FLUXA</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <h3 class="login-box-msg">Login</h3>

    <?php
    if(isset($_SESSION['msg_sucesso'])){
      ?>
      <p class="login-box-msg text-info"><?php echo ($_SESSION['msg_alerta']) ?></p>
      <?php

      unset($_SESSION['msg_sucesso']);
    }

    if(isset($_SESSION['msg_alerta'])){
      ?>
      <p class="login-box-msg text-warning"><?php echo ($_SESSION['msg_alerta']) ?></p>
      <?php
      unset($_SESSION['msg_alerta']);
    }

    if(isset($_SESSION['msg_erro'])){
      ?>
      <p class="login-box-msg text-danger"><?php echo ($_SESSION['msg_alerta']) ?></p>
      <?php
      unset($_SESSION['msg_erro']);
    }
    ?>

    <form action="login" method="post">

      <div class="form-group has-feedback">
        <input name="email" type="email" class="form-control" placeholder="Email" required>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>

      <div class="form-group has-feedback">
        <input name="senha" type="password" class="form-control" placeholder="Password" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        <div class="text-right">
          <a href="recuperar_senha" style="font-size: 13px;">Esqueci a senha</a>
        </div>
      </div>

      <div class="row">
        <!-- /.col -->
        <div class="col-xs-12">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Entrar</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    <div class="row">
	    <div class="social-auth-links text-center">
			 <p>ou</p>
      </div>
    </div>

    <div class="row">
      <div class="col-xs-12">
        <a href=<?php echo ($urlFacebook) ?> class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Entre com sua conta do Facebook </a>
      </div>
    </div>

    <div class="row" style="margin-top: 5px;">
      <div class="col-xs-12">
        <a href=<?php echo ($urlGoogle) ?> class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Entre com sua conta do Google+</a>
      </div>
    </div>
    <!-- /.social-auth-links -->

    <div class="row" style="margin-top: 15px;">
	     <div class="social-auth-links text-center">
	    	<a href="cadastro">Criar uma conta</a>
	    </div>
    </div>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="lib/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="lib/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>
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
