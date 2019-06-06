<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <title>Fluxa | Painel</title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="lib/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="lib/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="lib/Ionicons/css/ionicons.min.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="lib/jvectormap/jquery-jvectormap.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/template/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="dist/template/css/skins/_all-skins.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

</head>
<body class="hold-transition skin-blue sidebar-mini">

<div class="wrapper">

  <header class="main-header">

    <!-- Logo -->
    <a href="index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini">FLX</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg">FLUXA</span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src=<?php echo ($_SESSION['image']) ?> class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo ($_SESSION['nome']) ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src=<?php echo ($_SESSION['image']) ?> class="img-circle" alt="User Image">

                <p>
                    <?php echo ($_SESSION['nome']) ?>,
                    <small><?php echo ($_SESSION['email']) ?></small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Meu Perfil</a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo (URI_SISTEMA) ?>logout" class="btn btn-default btn-flat">Logout</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>

    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">

        <li class="active treeview menu-open">
          <a href="#">
            <i class="fa fa-dashboard"></i>
            <span>Main Menu 1</span>
            <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-circle-o"></i> Item Menu 1</a></li>
            <li class="active"><a href="#"><i class="fa fa-circle-o"></i>Item Menu 2</a></li>
          </ul>
        </li>

        <li class="treeview">

          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Main Menu 2</span>
            <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>

          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-circle-o"></i> Item Menu</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i> Item Menu</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i> Item Menu</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i> Item Menu</a></li>
          </ul>

        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Cadastro</a></li>
        <li class="active">Recurso</li>
      </ol>
    </section>

    <section class="content">

    	<div class="row">

        	<div class="col-md-6">

				<div class="box box-primary">

					<div class="box-header with-border">
						<h3 class="box-title">Cadastro de Potencialidade</h3>
					</div>

					<form role="form">
						<div class="box-body">
							<div class="form-group">
								<label for="inputNome">Nome</label>
								<input type="text" class="form-control" id="inputNome" placeholder="Nome do Recurso">
							</div>
						</div>
						<!-- /.box-body -->

						<div class="box-footer">
							<button type="submit" class="btn btn-primary">Salvar</button>
						</div>

					</form>

				</div>

			</div>

        </div>

	</section>


  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      Version 1.0
    </div>
    Aequalis &copy; 2017.
  </footer>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>

</div>

</body>

<!-- jQuery 3 -->
<script src="lib/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="lib/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="lib/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/template/js/adminlte.min.js"></script>
<!-- Sparkline -->
<script src="lib/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap  -->
<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- SlimScroll -->
<script src="lib/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- ChartJS -->
<script src="lib/chart.js/Chart.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!--<script src="dist/template/js/pages/dashboard2.js"></script> -->
<!-- AdminLTE for demo purposes -->
<script src="dist/template/js/demo.js"></script>

<script type="text/javascript">

    if (window.location.hash && window.location.hash == '#_=_') {
        if (window.history && history.pushState) {
            window.history.pushState("", document.title, window.location.pathname);
        } else {
            // Prevent scrolling by storing the page's current scroll offset
            var scroll = {
                top: document.body.scrollTop,
                left: document.body.scrollLeft
            };
            window.location.hash = '';
            // Restore the scroll offset, should be flicker free
            document.body.scrollTop = scroll.top;
            document.body.scrollLeft = scroll.left;
        }
    }

</script>