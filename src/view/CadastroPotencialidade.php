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
    	Cadastro de Potencialidade
  	</h1>

	<ol class="breadcrumb">
		<li><a href="<?php echo BASE_SISTEMA ?>painel"><i class="fa fa-th"></i> Painel</a></li>
		<li><a href="<?php echo BASE_SISTEMA ?>potencialidades">Potencialidades</a></li>
	</ol>
</section>

<section class="content">	

	<div class="box box-primary" style="padding: 10px;">

		<form role="form" method="POST" action="<?php echo BASE_SISTEMA ?>potencialidades/cadastro">

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
	
				<div class="form-group">
					<button type="submit" class="btn btn-primary btn-formulario">Salvar</button>	
					<button onclick="location.href='<?php echo BASE_SISTEMA ?>potencialidades'" type="button" class="btn btn-warning btn-formulario">Voltar</button>
				</div>		
				
			</div>
			<!-- /.box-body -->					

		</form>

	</div>

</section>

<script type="text/javascript">
    $('#inputNome').bootcomplete({
        url:'<?php echo BASE_SISTEMA ?>recursos/nome/json',
        minLength : 3
    });
</script>