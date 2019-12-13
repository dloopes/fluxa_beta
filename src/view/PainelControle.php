<?php
use Fluxa\View\Componente\CompMapaRecursos;
use Fluxa\Entity\Recurso;
?>
<!-- Content Header (Page header) -->
<section class="content-header">
  
  <h1 class="text-center">
    Ofereça o que tem e Receba o que precisa!
  </h1>

  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-th"></i> Painel</a></li>
  </ol>

</section>

<section class="content">

  <div class="box box-info">
    
    <div class="box-header">
      <i class="fa fa-filter"></i>
      <h3 class="box-title">Filtro</h3>
    </div>
    
    <div class="box-body">      
      <form action="<?php echo BASE_SISTEMA ?>painel/filtro" method="post">
        
        <div class="col-md-4">
          <div class="form-group has-success">
              <label for="inputNome">Nome do Recurso</label>
              <input type="text" placeholder="Ex. Bicicleta" class="form-control" id="inputNome" name="nome" value="<?= $nomeFiltro ?>" required style="height: 50px; font-size: 18px;">
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-group has-success">
            <label for="tipo_recurso">Tipo de Recurso</label>
            <select class="form-control" name="tipo_recurso" style="height: 50px; font-size: 18px;">
              <option value="" <?= (empty($tipoFiltro)?"selected":"") ?>>Todos</option>
              <option <?= ($tipoFiltro == Recurso::TIPO_POTENCIALIDADE?"selected":"") ?> value=<?= Recurso::TIPO_POTENCIALIDADE ?>>Buscar por Ofertas</option>
              <option <?= ($tipoFiltro == Recurso::TIPO_POSSIBILIDADE?"selected":"") ?> value=<?= Recurso::TIPO_POSSIBILIDADE ?>>Buscar por Necessidades</option>
            </select>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
             <button type="submit" class="form-control pull-right btn btn-success" id="btn_fluxar" style="margin-top: 25px; height: 50px; font-size: 18px;">Fluxar
          </div>
        </div>

      </form>
    </div> 

  </div>

  <?php
  if($tipoFiltro == Recurso::TIPO_POTENCIALIDADE){
    ?>
    <h3 class="text-muted text-center"><small><?= count($listaPotencialidades)." potencialidade(s) encontrada(s)" ?></small></h3>
    <?php
  }

  if($tipoFiltro == Recurso::TIPO_POSSIBILIDADE){
    ?>
    <h3 class="text-muted text-center"><small><?= count($listaPossibilidades)." possibilidade(s) encontrada(s)" ?></small></h3>
    <?php
  }
  ?>

  <?php
  $compMapaRecursos = new CompMapaRecursos($listaPotencialidades, $listaPossibilidades);
  $compMapaRecursos->imprimeHTML();
  ?>

</section>

<script type="text/javascript">
   
  $(document).ready(function() {

    $('#inputNome').bootcomplete({
      url:'<?php echo BASE_SISTEMA ?>recursos/nome/json',
      minLength : 3
    });

  });

</script>