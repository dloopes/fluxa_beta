<?php
use Fluxa\Entity\EnumRecursoStatus;
?>

<!-- Main content -->
<section class="content-header">
  
  <h1>
    Recursos que Necessito <small>(Minhas Possibilidades)</small>
  </h1>

  <ol class="breadcrumb">
    <li><a href="/sistema/painel"><i class="fa fa-th"></i> Painel</a></li>
  </ol>

</section>

<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<a href="possibilidades/cadastro" class="btn btn-primary btn-formulario">
				<i class="fa fa-plus"></i>	&nbsp;Novo
			</a>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12">
		  <div class="box">
		    <!-- /.box-header -->
		    <div class="box-body table-responsive no-padding">
		      <table class="table table-hover">
		        <tr>
		          <th>Nome</th>
		          <th>Status</th>
		          <th></th>
		        </tr>
		        
		        <?php
		        foreach ($listaPossibilidades as $possibilidade) {		        	
		        	?>
		        	<tr>
			          <td><?= $possibilidade->getNome() ?></td>
			          <td><?= EnumRecursoStatus::getValueView($possibilidade->getStatus()) ?></td>
			          <td>
			          	<a href="/sistema/mapa/recursos/potencialidade/<?= $possibilidade->getNome()?>" class="btn btn-warning btn-sm" title="Buscar Sinergia">
							<span class="glyphicon glyphicon-heart" aria-hidden="true"></span>
						</a>
			        	<a href="/sistema/possibilidades/cadastro/<?= $possibilidade->getId()?>" class="btn btn-primary btn-sm" title="Editar">
							<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
						</a>

						<?php
					        if($possibilidade->getStatus() != EnumRecursoStatus::INDISPO) {		        	
					        	?>
								<a 
								onclick="showMessageConf('Ao inativar o recurso ele não estará mais disponível para fluxo. Deseja realmente inativá-lo?', '/sistema/possibilidades/inativar/<?= $possibilidade->getId()?>')" class="btn btn-danger btn-sm" title="Inativar">
									<span class="glyphicon glyphicon-off" aria-hidden="true"></span>
								</a>
							<?php
					        }		        	
					    ?>

			          </td>
			        </tr>
		        	<?php
		        }
		        ?>

		        

		      </table>
		    </div>
		    <!-- /.box-body -->
		  </div>
		  <!-- /.box -->
		</div>
	</div>
</section>
<!-- /.content -->