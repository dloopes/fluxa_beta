<?php
use Fluxa\Entity\EnumRecursoStatus;
?>

<section class="content-header">
  
  <h1>
    Recursos que Ofereço <small>(Minhas Potencialidades)</small>
  </h1>

  <ol class="breadcrumb">
    <li><a href="/sistema/painel"><i class="fa fa-th"></i> Painel</a></li>
  </ol>

</section>
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<a href="potencialidades/cadastro" class="btn btn-primary btn-formulario">
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
		        foreach ($listaPotencialidades as $potencialidade) {		        	
		        	?>
		        	<tr>
			          <td><?= $potencialidade->getNome() ?></td>
			          <td><?= EnumRecursoStatus::getValueView($potencialidade->getStatus()) ?></td>
			          <td>
			          	<a href="/sistema/mapa/recursos/possibilidade/<?= $potencialidade->getNome()?>" class="btn btn-warning btn-sm" title="Buscar Sinergia">
							<span class="glyphicon glyphicon-heart" aria-hidden="true"></span>
						</a>
			        	<a href="/sistema/potencialidades/cadastro/<?= $potencialidade->getId()?>" class="btn btn-primary btn-sm" title="Editar">
							<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
						</a>
						
						<?php
					        if($potencialidade->getStatus() != EnumRecursoStatus::INDISPO) {		        	
					        	?>
								<a 
								onclick="showMessageConf('Ao inativar o recurso ele não estará mais disponível para fluxo. Deseja realmente inativá-lo?', '/sistema/potencialidades/inativar/<?= $potencialidade->getId()?>')" class="btn btn-danger btn-sm" title="Inativar">
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