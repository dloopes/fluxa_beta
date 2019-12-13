<?php
use Fluxa\Business\NotificacaoBusiness;
use Fluxa\Business\UsuarioBusiness;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <title>Fluxa | Painel</title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?php echo URI_SISTEMA ?>lib/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo URI_SISTEMA ?>lib/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo URI_SISTEMA ?>lib/Ionicons/css/ionicons.min.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="<?php echo URI_SISTEMA ?>lib/jvectormap/jquery-jvectormap.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo URI_SISTEMA ?>dist/template/css/AdminLTE.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo URI_SISTEMA ?>dist/template/css/skins/_all-skins.css">

    <link rel="stylesheet" href="<?php echo URI_SISTEMA ?>dist/css/bootcomplete.css">
    <link rel="stylesheet" href="<?php echo URI_SISTEMA ?>dist/css/vue_select.css?g=102">


     <link rel="stylesheet" href="<?php echo URI_SISTEMA ?>dist/css/painel.css">
     <link rel="stylesheet" href="<?php echo URI_SISTEMA ?>lib/jquery-ui/themes/base/autocomplete.css">


     <link href="<?php echo URI_SISTEMA ?>dist/js/dataTables/jquery.dataTables.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <!-- jQuery 3 -->

<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>



<script src="<?php echo URI_SISTEMA ?>dist/js/jquery-migrate-3.0.0.js?g=000009"></script>


<script type="text/javascript" src="<?=BASE_SISTEMA?>vue/dist/main.js?k=<?=K_ASSET?>"></script>

<script type="text/javascript" src="<?=BASE_SISTEMA?>dist/js/datatables/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?=BASE_SISTEMA?>dist/js/datatables/obj_datatable.js"></script>


<!-- <script src="<?php echo URI_SISTEMA ?>lib/jquery/dist/jquery.min.js"></script> -->
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo URI_SISTEMA ?>lib/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="<?php echo URI_SISTEMA ?>lib/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo URI_SISTEMA ?>dist/template/js/adminlte.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo URI_SISTEMA ?>lib/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap  -->
 <!-- <script src="<?php echo URI_SISTEMA ?>plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script> -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jvectormap/1.2.2/jquery-jvectormap.min.js"></script> 
<script src="<?php echo URI_SISTEMA ?>plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script> 
<!-- SlimScroll -->
<script src="<?php echo URI_SISTEMA ?>lib/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- ChartJS -->
<script src="<?php echo URI_SISTEMA ?>lib/chart.js/Chart.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!--<script src="dist/template/js/pages/dashboard2.js"></script> -->
<!-- AdminLTE for demo purposes -->
<script src="<?php echo URI_SISTEMA ?>dist/template/js/demo.js"></script>

<script src="<?php echo URI_SISTEMA ?>dist/js/bootcomplete.js"></script>

<script src="<?php echo URI_SISTEMA ?>dist/js/bootbox.min.js"></script>
<script src="<?php echo URI_SISTEMA ?>dist/js/sweetalert/sweetalert2.all.min.js"></script>
<script type="text/javascript">
window.K_AUTHORIZATION = "<?php echo UsuarioBusiness::getAuthorizationApi() ?>";    
window.URL_API = "<?= URL_API ?>";    
</script>
<style>
#div_drag{
    width:99%;
    height:100px;
    line-height:100px;
    border:5px dashed #CCC;

    font-family:Verdana;
    text-align:center;
}

</style>
</head>
<body class="hold-transition skin-blue sidebar-mini">

<div class="wrapper">

  <header class="main-header">

    <!-- Logo -->
    <a href="<?php echo URI_SISTEMA ?>painel" class="logo">
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

          <?php
          $notificacaoBusiness = new NotificacaoBusiness();
          $notificacoes = $notificacaoBusiness->buscarPorIdUsuario($_SESSION['id'], 0);
          ?>

          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-bell-o"></i>
                <?php
                if(count($notificacoes) > 0){
                  ?>
                    <span class="label label-warning"><?= count($notificacoes)?></span>
                  <?php
                }
                ?>
              </a>
              
            <ul class="dropdown-menu">
              <li class="header">Você tem <?= count($notificacoes)?> notificações</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">

                  <?php
                  foreach ($notificacoes as $notificacao) {
                      ?>
                      <li>
                        <a href=<?= URI_SISTEMA . 'notificacao/'.$notificacao->getId() ?>>
                          <i class="fa fa-users text-aqua"></i> <?= $notificacao->getTexto()?>
                        </a>
                      </li>
                      <?php
                  }
                  ?>
                 </ul>
              </li>
              <li class="footer"><a href="#">Ver Todos</a></li>
            </ul>
          </li>
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
                  <a href="<?php echo URI_SISTEMA ?>logout" class="btn btn-default btn-flat">Logout</a>
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

        <li>
          <a href="<?php echo URI_SISTEMA ?>painel">
            <i class="fa fa-th"></i> <span>Painel</span>
          </a>
        </li>

        <li class="treeview active">
          <a href="#">
            <i class="fa fa-dashboard"></i>
            <span>Recursos</span>
            <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo URI_SISTEMA ?>potencialidades"><i class="fa fa-circle-o text-aqua"></i> Ofereço</a></li>
            <li><a href="<?php echo URI_SISTEMA ?>possibilidades"><i class="fa fa-circle-o text-green"></i> Necessito</a></li>
            <li><a href="<?php echo URI_SISTEMA ?>fluxos"><i class="fa fa-circle-o"></i> Meus Fluxos</a></li>
          </ul>
        </li>
        
        
           <li class="treeview active">
          <a href="#">
            <i class="fa fa-dashboard"></i>
            <span>Narrativas</span>
            <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li style="display:none"><a href="<?php echo URI_SISTEMA ?>iniciativas"><i class="fa fa-circle-o text-aqua"></i> Buscar Iniciativas</a></li>
            <li><a href="<?php echo URI_SISTEMA ?>iniciativas_my"><i class="fa fa-circle-o text-green"></i> Minhas Iniciativas</a></li>
          </ul>
        </li>

        <li class="header text-center" style="padding-top: 20px;">TOTAL PLATAFORMA

        
          <p class="text-left" style="color: #b8c7ce; padding: 20px 15px 0px 0px;">
            <i class="fa fa-circle-o text-red"></i>
            <a href="<?php echo URI_SISTEMA ?>usuarios/1" style="padding: 0px; border-left: none;">
              <span style="margin-left: 10px;"><?php echo($_SESSION['qtde_total_usuarios']) ?> Usuários </span>
            </a>
          </p>
       
          <p class="text-left" style="color: #b8c7ce; padding: 10px 15px 0px 0px;">
            
            <a href="<?php echo URI_SISTEMA ?>potencialidades/all/1" style="padding: 0px; border-left: none;">
              <i class="fa fa-circle-o text-aqua"></i>
              <span style="margin-left: 10px;"><?php echo($_SESSION['qtde_total_potencialidades'])?> Ofertas </span>
            </a>
          </p>

          <p class="text-left" style="color: #b8c7ce; padding: 10px 15px 0px 0px;">
            <a href="<?php echo URI_SISTEMA ?>possibilidades/all/1" style="padding: 0px; border-left: none;">
              <i class="fa fa-circle-o text-green"></i>
              <span style="margin-left: 10px;"><?php echo($_SESSION['qtde_total_possibilidades']) ?> Necessidades </span>
            </a>
          </p>

        </li>

        <li class="header text-center" style="padding-top: 20px;">RESULTADOS 4D

          <p class="text-left" style="color: #b8c7ce; padding: 10px 15px 0px 0px;">
            <a href="#" 
              onclick="showMessageAlert('A cada recurso cadastrado na plataforma, a equipe Fluxa se compromete em plantar uma nova árvore.', '#')" title="Saiba mais...">
                <i class="fa fa-envira text-green"></i>
                <span style="margin-left: 8px;"><?php echo($_SESSION['qtde_total_potencialidades'] + $_SESSION['qtde_total_possibilidades'])?> Árvores </span>
            </a>
          </p>

        </li>

        <li class="header text-center" style="padding-top: 20px;">PRECISA DE AJUDA?

        <!-- Profile Image -->
          <div class="box box-default" style="margin-top: 20px;">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="<?php echo URI_SISTEMA ?>dist/template/img/foto_diogo.jpg" alt="User profile picture">

              <h3 class="profile-username text-center">Diogo Loopes</h3>

              <p class="text-muted text-center">Fale comigo</p>

              <div class="text-center">
                <a class="btn btn-social-icon btn-facebook" href="https://www.facebook.com/dasanandahari" target="_blank"><i class="fa fa-facebook"></i></a>
                <a class="btn btn-social-icon btn-linkedin" href="https://www.linkedin.com/in/diogo-de-castro-lopes-93493a17/" target="_blank"><i class="fa fa-linkedin"></i></a>
                <a class="btn btn-social-icon btn-twitter" href="https://twitter.com/DiogoGuarani" target="_blank"><i class="fa fa-twitter"></i></a>
              </div>

              <br/>
              
              <p class="text-muted text-center"><b>Whatsapp:</b><br/>(61) 99806-3575</p>

              <p class="text-muted text-center"><b>E-mail:</b><br/>diogo@nascentes.org.br</p>

              <p class="text-muted text-center"><b>Skype:</b><br/>lopesdiogo</p>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          </li>

        </ul>
      
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">    

    <!-- Mensagens de sucesso, aleta e erro de interação com usuario -->

    <?php
    if(isset($_SESSION['msg_sucesso'])){
      ?>
      <div class="pad margin no-print">
        <div class="callout callout-info" style="margin-bottom: 0!important;">
          <?=$_SESSION['msg_sucesso']?>
        </div>
      </div>
      <?php

      unset($_SESSION['msg_sucesso']);
    }

    if(isset($_SESSION['msg_alerta'])){
      ?>
      <div class="pad margin no-print">
        <div class="callout callout-warning" style="margin-bottom: 0!important;">
          <?=$_SESSION['msg_alerta']?>
        </div>
      </div>
      <?php
      unset($_SESSION['msg_alerta']);
    }

    if(isset($_SESSION['msg_erro'])){
      ?>
      <div class="pad margin no-print">
        <div class="callout callout-danger" style="margin-bottom: 0!important;">
          <?=$_SESSION['msg_erro']?>
        </div>
      </div>
      <?php
      unset($_SESSION['msg_erro']);
    }
    ?>  

  	<?php include $pagina; ?>

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

<div id="div_error_api"></div>
</body>

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

    //Função responsável por apresentar a mensagem de confirmação
    function showMessageConf(mensagem, linkConf){
      bootbox.confirm(mensagem, function(result) {
        if(result){
          location.href = linkConf;
        }     
      }); 
    }

     function showMessageAlert(mensagem){
      bootbox.alert({
        message: mensagem,
        backdrop: true,
        //size: 'small',
        buttons: {
          ok: {
            label: 'OK'
          }
        }
      });
    }

    function sendFormFluxo(formId){

        var form = document.getElementById(formId);

        bootbox.confirm("Você realmente deseja gerar um novo fluxo?", function(result) {
          if(result){
            form.submit();
          }     
        }); 
      }

     /* 
$.ajaxSetup({
       beforeSend: function (xhr)
       {
          console.log("setando authorization");
          xhr.setRequestHeader("Authorization",window.K_AUTHORIZATION); 
       }
 }); 
 */
</script>