<?php
use Fluxa\Entity\Endereco;
use Fluxa\View\Componente\CompDadosEndereco;
use Fluxa\View\Componente\CompSelectTipoFluxo;
use Fluxa\View\Componente\CompSelectStatusRecurso;
use Fluxa\View\Componente\CompSelectCategoriaRecurso;
?>

<!-- Content Header (Page header) -->
<section class="content-header">

	<h1>
    	Cadastro de Possibilidade
  	</h1>

	<ol class="breadcrumb">
		<li><a href="/sistema/painel"><i class="fa fa-th"></i> Painel</a></li>
		<li><a href="/sistema/potencialidades">Potencialidades</a></li>
	</ol>
</section>

<section class="content">	

	<div class="box box-primary" style="padding: 10px;">

		<form role="form" method="POST" action="/sistema/possibilidades/cadastro">

			<div class="box-body">	

				<div class="row">
					<div class="col-md-8">
						<div class="form-group">
							<input type="hidden" class="form-control" id="inputId" name="id" value="<?= $recurso->getId()?>">
						</div>	
					</div>	
				</div>		
				
				<div class="row">
					<div class="col-md-8">
						<div class="form-group">
							<label for="inputNome">Nome do Recurso *</label>
							<input type="text" class="form-control" id="inputNome" name="nome" value="<?= $recurso->getNome()?>" placeholder="Nome do Recurso" required>
						</div>
					</div>			
				</div>		

				<div class="row">
					<div class="col-md-8">
						<div class="form-group">
							<label for="inputNome">Detalhes *</label>
							<textarea name="detalhe" placeholder="Detalhe do Recurso" maxlength="500" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px; resize: none;" required><?= $recurso->getDetalhe() ?></textarea>
						</div>
					</div>	
				</div>				
				
				<?php
				$compSelectCategoriaRecurso = new CompSelectCategoriaRecurso($listaCategorias, $recurso->getCategoria());
				$compSelectCategoriaRecurso->imprimeHTML();
				?>			

				<div class="row">
				<?php
				$compSelectStatusRecurso = new CompSelectStatusRecurso($listaStatus, $recurso->getStatus(), "col-md-4", false);
				$compSelectStatusRecurso->imprimeHTML();
				?>		
				
				<?php
				$compSelectTipoFluxo = new CompSelectTipoFluxo($listaTiposFluxo, $recurso->getTipoFluxo(), "col-md-4", false);
				$compSelectTipoFluxo->imprimeHTML();
				?>	
				</div>	
				
				<?php
				$compDadosEndereco = new CompDadosEndereco($recurso->getEndereco());
				$compDadosEndereco->imprimeHTML();
				?>	
				
				<div class="row" style="margin-top: 15px;">
					<div class="col-md-8">
						<div class="form-group">
							<button type="submit" class="btn btn-primary btn-formulario">Salvar</button>	
							<button onclick="location.href='/sistema/possibilidades'" type="button" class="btn btn-warning btn-formulario">Voltar</button>
						</div>
					</div>			
				</div>
			</div>
			<!-- /.box-body -->					

		</form>

	</div>

</section>

<script type="text/javascript">
   
	$(document).ready(function() {

		$('#inputNome').bootcomplete({
			url:'/sistema/recursos/nome/json',
			minLength : 3
		});

	});

</script>