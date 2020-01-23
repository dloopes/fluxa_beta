<?php
use Fluxa\View\Componente\CompMapaRecursos;
use Fluxa\Entity\Recurso;
use Fluxa\Entity\EnumRecursoStatus;
use Fluxa\Entity\EnumTiposFluxo;
?>

<!-- Content Header (Page header) -->
<section class="content-header" style="padding-top: 30px;">

	<ol class="breadcrumb">
		<li><a href="/sistema/painel"><i class="fa fa-th"></i> Painel</a></li>
		<li><a href="/sistema/fluxos">Meus Fluxos</a></li>
	</ol>

</section>

<!-- Main content -->
<section class="content">

	<div class="row">
	
		<div class="col-md-7" style="margin-top: 14px;">
			
			<div class="box box-primary">
			
				<div class="box-body" style="padding-top: 20px;">

					<div class="user-block">						
						<img class="img-circle" src="<?= $recurso->getUsuario()->getUrlImagem()?>" alt="User Image">
						<span class="username" style="margin-top: 10px;"><a href="<?= URI_SISTEMA."usuario/".$recurso->getUsuario()->getId()?>"><?= $recurso->getUsuario()->getNome()?></a> <?php echo($recurso->getTipo() == Recurso::TIPO_POTENCIALIDADE ? "oferece " : "necessita de ")?> um(a) <a class="pull"><?= $recurso->getNome()?></a></span>
					</div>

					<hr>

					<label>
						<?php echo($recurso->getTipo() == Recurso::TIPO_POTENCIALIDADE ? "Oferta" : "Necessidade")?>
					</label>
					<p><a class="pull"><?php echo($recurso->getNome()) ?></a></p>

					<label>Detalhes</label>
					<p><a class="pull"><?php echo($recurso->getDetalhe()) ?></a></p>

					<label>Dimensão</label>
					<p><a class="pull"><?php echo($recurso->getCategoria()->getNome()) ?></a></p>

					<label>Status</label>
					<p><a class="pull"><?php echo(EnumRecursoStatus::getValueView($recurso->getStatus())) ?></a></p>

					<label>Tipo de Fluxo</label>
					<p><a class="pull"><?php echo(EnumTiposFluxo::getValueView($recurso->getTipoFluxo())) ?></a></p>

					<label>Endereço</label>
					<p>
						<a class="pull"><?=
							$recurso->getEndereco()->getCep()." - ".$recurso->getEndereco()->getLogradouro().", nº ".$recurso->getEndereco()->getNumero()." ".$recurso->getEndereco()->getComplemento(). " - ".$recurso->getEndereco()->getBairro().", ".$recurso->getEndereco()->getCidade()." - ".$recurso->getEndereco()->getEstado()." | ".$recurso->getEndereco()->getPais()
							?>							
						</a>
					</p>

					<br/>

				</div>

			</div>

			<?php
			if($recurso->getUsuario()->getId() != $_SESSION['id']){
	        	?>						            	
	        	<form method="POST" action="/sistema/fluxo" id=<?php echo("form_".$recurso->getId())?>> 
	        		<div class="text-left">
		        		<input type="hidden" name="id_recurso" value=<?php echo($recurso->getId())?> /> 
		        	 	<input type="button" style="min-width: 150px;" class="btn btn-success btn-flat" title="Fluxar" onclick="sendFormFluxo(<?php echo("form_".$recurso->getId())?>);" value="Fluxar"/>
	        	 	</div>
	        	</form>	
	        	<?php
	        }
	        ?>

		</div>

		<div class="col-md-5">

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

				//$compMapaRecursos->setMarkerOpened(true);
				$compMapaRecursos->setHeightMap("500px");

				$compMapaRecursos->imprimeHTML(false);

			?>
			
		</div>

	</div>

</section>
<!-- /.content -->

