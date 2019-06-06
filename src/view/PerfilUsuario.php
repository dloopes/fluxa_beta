<?php
use Fluxa\Entity\Fluxo;
use Fluxa\Entity\Recurso;
use Fluxa\View\Componente\CompTabelaDados;
use Fluxa\View\Componente\ControladorTabelaFluxos;
use Fluxa\View\Componente\ControladorTabelaRecursos;
?>

<!-- Content Header (Page header) -->
<section class="content-header">

	<h1>
		Perfil do Usuário
	</h1>

	<ol class="breadcrumb">
		<li><a href="/sistema/painel"><i class="fa fa-th"></i> Painel</a></li>
	</ol>
</section>

<!-- Main content -->
<section class="content">

	<div class="row">		
		
		<!-- /.col -->
		<div class="col-md-12">
			<!-- Widget: user widget style 1 -->
			<div class="box box-widget widget-user">
				<!-- Add the bg color to the header using any of the bg-* classes -->
				<div class="widget-user-header bg-aqua-active">
					<h5 class="widget-user-desc">Cadastrado em <?= date('d/m/y - H:i:s', strtotime($usuario->getDataCadastro()))?></h5>
					<h3 class="widget-user-username"><?=$usuario->getNome()?></h3>
				</div>
				<div class="widget-user-image">
					<img class="img-circle" style="width: 85px; height: 85px;" src=<?=$usuario->getUrlImagem()?>>
				</div>
				<div class="box-footer">
					<div class="row" style="padding: 10px;">
						<div class="col-sm-4 border-right" style="border-bottom: solid; border-bottom-width: 1px; padding:5px 5px 20px 5px; 
							<?php echo($tab === "ofertas"?"border-bottom-color: #00a7d0":"border-bottom-color: #f4f4f4")?>;">
							<div class="description-block">
								<h5 class="description-header"><?=$dados['u1_total_ofertas']?></h5>
								<a href=<?php echo(URI_SISTEMA . 'usuario/'.$usuario->getId().'/ofertas/1')?>><span class="description-text">OFERTAS</span></a>
							</div>

							<!-- /.description-block -->
						</div>
						<!-- /.col -->
						<div class="col-sm-4 border-right" style="border-bottom: solid; border-bottom-width: 1px; padding:5px 5px 20px 5px; <?php echo($tab === "necessidades"?"border-bottom-color: #00a7d0":"border-bottom-color: #f4f4f4")?>;">
							<div class="description-block">
								<h5 class="description-header"><?=$dados['u1_total_necessidades']?></h5>
								<a href=<?php echo(URI_SISTEMA . 'usuario/'.$usuario->getId().'/necessidades/1')?>><span class="description-text">NECESSIDADES</span></a>
							</div>
							<!-- /.description-block -->
						</div>
						<!-- /.col -->
						<div class="col-sm-4 border-right" style="border-bottom: solid; border-bottom-width: 1px; padding:5px 5px 20px 5px; <?php echo($tab === "fluxos"?"border-bottom-color: #00a7d0":"border-bottom-color: #f4f4f4")?>;">
							<div class="description-block">
								<h5 class="description-header"><?=$dados['u1_total_fluxos']?></h5>
								<a href=<?php echo(URI_SISTEMA . 'usuario/'.$usuario->getId().'/fluxos/1')?>><span class="description-text">FLUXOS</span></a>
							</div>
							<!-- /.description-block -->
						</div>
						<!-- /.col -->
					</div>
					<!-- /.row -->
				</div>
			</div>
			<!-- /.widget-user -->
		</div>

		<div class="col-md-12">
			<?php 
			switch ($tab) {
				case 'ofertas':
					?>
					<!--<h1 class="text-center">
						<small>Ofertas</small>
					</h1>-->
					<div class="row">
						<?php
						$compTabela = new CompTabelaDados($numPag, new ControladorTabelaRecursos($numPag));
						$compTabela->setItens($listaPotencialidades);
						$compTabela->desativarTodasOpcoes();
						$compTabela->imprimeHTML();
						?>
				    </div>
					<?php
					break;
				case 'necessidades':
					?>
					<!--<h1 class="text-center">
						<small>Necessidades</small>
					</h1>-->
					<div class="row">
						<?php
						$compTabela = new CompTabelaDados($numPag, new ControladorTabelaRecursos($numPag));
						$compTabela->setItens($listaPossibilidades);
						$compTabela->desativarTodasOpcoes();
						$compTabela->imprimeHTML();
						?>
				    </div>
					<?php
					break;
				case 'fluxos':
					?>
					<!--<h1 class="text-center">
						<small>Fluxos</small>
					</h1>-->
					<div class="row">
						<?php
						$compTabela = new CompTabelaDados($numPag, new ControladorTabelaFluxos($numPag));
						$compTabela->setItens($listaFluxos);
						$compTabela->desativarTodasOpcoes();
						$compTabela->imprimeHTML();
						?>
				    </div>
					<?php
					break;			
				default:
					break;
			}
			?>

			<!--<row>
				<div class="form-group" style="margin: 10px 0px 0px 0px;">
					<a href="javascript:history.back()" class="btn btn-warning btn-formulario">Voltar</a>	
				</div>
			</row>-->

		</div>

		<div class="col-md-12">
			
		</div>

	</div><!-- /.row -->

</section>
<!-- /.content -->

