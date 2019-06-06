<?php
use Fluxa\Entity\Usuario;
use Fluxa\View\Componente\CompTabelaDados;
use Fluxa\View\Componente\ControladorTabelaUsuarios;
?>

<section class="content-header">
  
  <h1>
    Usuários Cadastrados
  </h1>

  <ol class="breadcrumb">
    <li><a href="/sistema/painel"><i class="fa fa-th"></i> Painel</a></li>
  </ol>

</section>
<!-- Main content -->
<section class="content">
    <div class="row">
      <?php
          $compTabela = new CompTabelaDados($numPag, new ControladorTabelaUsuarios($numPag));
          $compTabela->setItens($listaUsuarios);
          $compTabela->desativarTodasOpcoes();
          $compTabela->imprimeHTML();
      ?>
    </div>
</section>
<!-- /.content -->