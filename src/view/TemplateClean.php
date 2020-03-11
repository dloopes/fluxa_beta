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
     <link rel="stylesheet" href="<?php echo URI_SISTEMA ?>dist/css/modal.css">
     <link rel="stylesheet" href="<?php echo URI_SISTEMA ?>lib/jquery-ui/themes/base/autocomplete.css">

     <link rel="stylesheet" href="<?php echo URI_SISTEMA ?>lib/gallery/pagination.css">

     <link href="<?php echo URI_SISTEMA ?>dist/js/datatables/jquery.dataTables.min.css" rel="stylesheet">
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
<script src="<?php echo URI_SISTEMA ?>dist/js/jquery.modal.colorbox-min.js"></script>

<script src="<?php echo URI_SISTEMA ?>lib/gallery/pagination.js?g=999"></script>
<script type="text/javascript">
window.K_AUTHORIZATION = "<?php echo UsuarioBusiness::getAuthorizationApi() ?>";    
window.URL_API = "<?= URL_API ?>";    
window.K_USER_ID = "<?php echo UsuarioBusiness::getSessionIDUsuario() ?>";
window.K_URL_SISTEMA = "<?php echo BASE_SISTEMA ?>";

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
<body >

<div class="wrapper">
    
    
  	<?php include $pagina; ?>
</div>
</body>