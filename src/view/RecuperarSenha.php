<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>Fluxa | Sign in</title>
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
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="login"><b>FLUXA</b></a>
  </div>

  <div class="register-box-body">
    <h3 class="login-box-msg">Recuperar Senha</h3>

<?php
if (!empty($msg)) {
	?>
    <p class="login-box-msg text-danger"><?php echo ($msg) ?></p>
  <?php
}
?>

    <form action="recuperar_senha" method="post">


      <div class="form-group has-feedback">
        <input name="email" type="email" class="form-control" placeholder="Email"  value="<?php echo ($usuario->getEmail()) ?>" required>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-xs-12">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Enviar</button>
        </div>
        <!-- /.col -->
      </div>
      <div class="form-group has-feedback">
       <div class="social-auth-links text-center">
        <p class="text-success">"Um email será enviado para você"</p>
      </div>
      </div>
    </form>

    <div class="row text-center" style="margin-top: 20px;">
      <a href="login"><<  Voltar</a>
    </div>
  </div>
  <!-- /.form-box -->
</div>
<!-- /.register-box -->

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