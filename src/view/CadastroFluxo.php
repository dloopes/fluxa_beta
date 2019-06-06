<?php
use Fluxa\View\Componente\CompMapaRecursos;
use Fluxa\Entity\Fluxo;
?>

<!-- Content Header (Page header) -->
<section class="content-header">

	<h1>
		Detalhes do Fluxo
	</h1>

	<ol class="breadcrumb">
		<li><a href="/sistema/painel"><i class="fa fa-th"></i> Painel</a></li>
		<li><a href="/sistema/fluxos">Meus Fluxos</a></li>
	</ol>
</section>

<!-- Main content -->
<section class="content">

	<div class="row">
	
		<div class="col-md-8">

			<div class="box box-widget" style="margin-top: 14px;">
				<div class="box-header with-border">
					<div class="user-block">						
						<img class="img-circle" src="<?=$fluxo->getUsuarioIniciouFluxo()->getUrlImagem()?>" alt="User Image">
						<span class="username" style="margin-top: 10px;"><a href="#"><?=$fluxo->getMensagemDoFluxo()?></a>
							<?php
							if($fluxo->getStatus() == Fluxo::STATUS_REALIZADO){
								?>
								<span class="text-primary pull-right">
									"Fluxo <?= $fluxo->getStatus()?>"							
								</span>
								<?php
							}else if($fluxo->getStatus() == Fluxo::STATUS_INTERROMPIDO){
								?>
								<span class="text-danger pull-right">
									"Fluxo <?= $fluxo->getStatus()?>"							
								</span>
								<?php
							}else{
								?>
								<span class="text-secondary pull-right">
									"Fluxo <?= $fluxo->getStatus()?>"							
								</span>
								<?php
							}
							?>

							
						</span>
					</div>
				</div>
				<!-- /.box-header -->



				<?php
				if(!empty($listaMensagens)){
					?>

					<!-- /.box-body -->
					<div class="box-footer box-comments">							
						<?php
						foreach ($listaMensagens as $mensagem) {							
							?>
							<div class="box-comment">
								<!-- User image -->
								<img class="img-circle img-sm" src=<?= $mensagem->getUsuarioRemetente()->getUrlImagem()?>>
								<div class="comment-text">
									<span class="username">
										<a href=<?php echo(URI_SISTEMA."usuario/".$mensagem->getUsuarioRemetente()->getId()) ?> data-toggle='tooltip' title=<?php echo($mensagem->getUsuarioRemetente()->getEmail())?>>
										<?php echo($mensagem->getUsuarioRemetente()->getNome()) ?>
										</a>
										<span class="text-muted pull-right">
											<?= date('d/m/y - H:i:s', strtotime($mensagem->getDateInsert()))?>
										</span>
									</span><!-- /.username -->
									<?= $mensagem->getTexto()?>
								</div>
								<!-- /.comment-text -->
							</div>
							<?php

						}
						?>
					</div>
				<?php
				}
				?>						

				<?php
				if($podeEnviarMsg){
					?>
					<!-- /.box-footer -->
					<div class="box-footer">
						<form method="POST" action="/sistema/fluxo/mensagem">
							<img class="img-responsive img-circle img-sm" src=<?= $_SESSION['image']?>>
							<!-- .img-push is used to add margin to elements next to floating images -->
							<div class="img-push">
								<div class="input-group">										
									<input type="hidden" name="id_fluxo" value=<?= $fluxo->getId()?>>
									<input type="text" name="texto" placeholder="Envie uma Mensagem ..." class="form-control" required>
									<span class="input-group-btn">
										<button type="submit" class="btn btn-primary btn-flat">Enviar</button>
									</span>
								</div>
							</div>
						</form>
					</div>
					<!-- /.box-footer -->
					<?php
				}
				?>
			</div>
			<!-- /.box -->

		<?php
		if(
			$fluxo->getStatus() === Fluxo::STATUS_POTENCIAL && $fluxo->getUsuarioRecebeuFluxo()->getId() == $_SESSION['id']
		){
			?>
			<form method="POST" action="/sistema/fluxo/status/">
				<div class="text-left">
					<input type="hidden" name="id_fluxo" value=<?= $fluxo->getId()?>>
					<button type="submit" class="btn btn-primary btn-flat" name="opcao" value="1"><i class="fa fa-thumbs-o-up"></i> Fluxado (De Acordo)</button>
					<button type="submit" class="btn btn-danger btn-flat" name="opcao" value="0"><i class="fa fa-hand-stop-o"></i> Interromper Fluxo</button>					
				</div>
			</form>
			<?php
		}
		?>

		<?php
		/*if(
			$fluxo->getStatus() === Fluxo::STATUS_REALIZADO && $fluxo->getUsuarioIniciouFluxo()->getId() == $_SESSION['id']
		){
			?>
			<form method="POST" action="/sistema/fluxo/status/">
				<div class="text-left">
					<input type="hidden" name="id_fluxo" value=<?= $fluxo->getId()?>>
					<button type="submit" class="btn btn-danger btn-flat" name="opcao" value="0"><i class="fa fa-hand-stop-o"></i> Interromper Fluxo</button>					
				</div>
			</form>
			<?php
		}*/
		?>	

		</div>



		<div class="col-md-4">

			<row style="height: 200px;">
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
		  
		  		$compMapaRecursos->setHeightMap("300px");
				$compMapaRecursos->imprimeHTML(false);
				?>
			</row>
			
		</div>

	</div>
	<!-- /.row -->

	<!--<div class="row">
		<div class="col-md-12">
			<div class="form-group" style="margin: 10px 0px 0px 0px;">
				<a href="/sistema/fluxos" class="btn btn-warning btn-formulario">Voltar</a> 
			</div>
		</div>
	</div>-->

</section>
<!-- /.content -->

