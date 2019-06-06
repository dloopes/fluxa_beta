<?php
use Fluxa\View\Componente\CompMapaRecursos;
use Fluxa\Entity\EnumTiposFluxo;
use Fluxa\Entity\EnumRecursoStatus;
?>

<!-- Content Header (Page header) -->
<section class="content-header">

	<ol class="breadcrumb">
		<li><a href="/sistema/painel"><i class="fa fa-dashboard"></i> Painel</a></li>
		<li><a href="/sistema/potencialidades">Potencialidades</a></li>
	</ol>

</section>

<br/><br/>

<section class="content" style="padding: 15px 25px 15px 25px;">	
	  <?php

	  $compMapaRecursos = new CompMapaRecursos($listaPotencialidades, $listaPossibilidades);
	 	
	  if(isset($latitudeDefault)){
	  	$compMapaRecursos->setLatitudeCenter($latitudeDefault);
	  }

	  if(isset($longitudeDefault)){
	  	$compMapaRecursos->setLongitudeCenter($longitudeDefault);
	  }

	  if(isset($zoomDefault)){
	  	$compMapaRecursos->setZoomDefault($zoomDefault);
	  }  

	  $compMapaRecursos->setMarkerOpened(true);
	  
	  $compMapaRecursos->imprimeHTML();
	  ?>		
</section>