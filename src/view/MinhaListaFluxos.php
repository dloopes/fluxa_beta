<?php
use Fluxa\Entity\Fluxo;
use Fluxa\View\Componente\CompTabelaDados;
use Fluxa\View\Componente\ControladorTabelaFluxos;
?>

<section class="content-header">
  
  <h1>
    Meus Fluxos
  </h1>

  <ol class="breadcrumb">
    <li><a href="/sistema/painel"><i class="fa fa-th"></i> Painel</a></li>
  </ol>

</section>
<!-- Main content -->
<section class="content">
    <div class="row">
      <?php
          $compTabela = new CompTabelaDados($numPag, new ControladorTabelaFluxos($numPag));
          $compTabela->setItens($listaFluxos);
          $compTabela->desativarTodasOpcoes();
          $compTabela->imprimeHTML();
      ?>
    </div>
</section>
<!-- /.content -->