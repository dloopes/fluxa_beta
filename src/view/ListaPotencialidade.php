<?php
use Fluxa\Entity\Recurso;
use Fluxa\View\Componente\CompTabelaDados;
use Fluxa\View\Componente\ControladorTabelaRecursos;
?>

<section class="content-header">
  
  <h1>
    Ofertas Cadastradas
  </h1>

  <ol class="breadcrumb">
    <li><a href="/sistema/painel"><i class="fa fa-th"></i> Painel</a></li>
  </ol>

</section>
<!-- Main content -->
<section class="content">
    <div class="row">
      <?php
          $compTabela = new CompTabelaDados($numPag, new ControladorTabelaRecursos($numPag));
          $compTabela->setItens($listaPotencialidades);
          $compTabela->desativarTodasOpcoes();
          $compTabela->imprimeHTML();
      ?>
    </div>
</section>
<!-- /.content -->