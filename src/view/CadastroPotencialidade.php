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

		<form role="form" id="formRec" name="formRec" method="POST" action="<?php echo BASE_SISTEMA ?>potencialidades/cadastro">
	<div class="box box-primary" style="padding: 10px;">


			<div class="box-body">	

				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<input type="hidden" class="form-control" id="inputId" name="id" value="<?= $recurso->getId()?>">
						</div>
					</div>	
				</div>		
				
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="inputNome">Nome do Recurso *</label>
							<input type="text" class="form-control" id="inputNome" name="nome" value="<?= $recurso->getNome()?>" placeholder="Nome do Recurso" required>
						</div>
					</div>	
				</div>	

				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="inputNome">Detalhes *</label>
							<textarea name="detalhe" id="inputDetalhe" placeholder="Detalhe do Recurso" maxlength="500" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px; resize: none;" required><?= $recurso->getDetalhe() ?></textarea>
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
				//$compDadosEndereco = new CompDadosEndereco($recurso->getEndereco());
				//$compDadosEndereco->imprimeHTML();
				?>							
		
				
			</div>
                    
      
			<!-- /.box-body -->					

            

	</div>
    
    
    
    	                   <div class="row" id="app">
                                
                                <cad_endereco_for_externo id_load="<?= $recurso->getId()?>"></cad_endereco_for_externo>
                                
                                <input type="hidden" id="hd_endereco_data" name="hd_endereco_data" >
                                <input type="hidden" id="hd_form_data" name="hd_form_data" >
                            </div>
       
		</form>                     
                          
	<div class="box" >
			<div class="box-body">	
                    
				<div class="form-group">
					<button type="button" id="bt_submit" class="btn btn-primary btn-formulario">Salvar</button>	
					<button onclick="location.href='<?php echo BASE_SISTEMA ?>potencialidades'" type="button" class="btn btn-warning btn-formulario">Voltar</button>
				</div>	
                            
                        </div>
			</div>

</section>

<script type="text/javascript" src="<?=BASE_SISTEMA?>dist/fluxa/recurso.js?k=<?=K_ASSET?>"></script>
<script type="text/javascript">
    $('#inputNome').bootcomplete({
        url:'<?php echo BASE_SISTEMA ?>recursos/nome/json',
        minLength : 3
    });
    
   function validar(){
    
    if ( obj_alert.isvazioInput("inputNome", "Informe o nome"))
        return false;
    
    
    if ( obj_alert.isvazioInput("inputDetalhe", "Informe os detalhes"))
        return false;
    
    var json_form = JSON.parse(  $("#hd_form_data").val() );
    var json_endereco = JSON.parse(  $("#hd_endereco_data").val() );
    
     if (json_form.tipo_endereco == "F") {
        var res_endereco = msgValidaEndereco( json_endereco ); //recurso.js

        if (res_endereco.length > 0) {
          obj_alert.show(
            "Atenção",
            "Endereço: " + res_endereco[0].msg,
            "warning",
            null
          );
          return false;
        }
      } else {
        if (obj_alert.isvazioInput(
            "f_url_endereco_virtual",
            "Informe a URL do endereço virtual"))
          return false;
      }
    
      //  <input type="hidden" id="hd_endereco_data" name="hd_endereco_data" >
          //                      <input type="hidden" id="hd_form_data" name="hd_form_data" >
    
    return true;
    
}
$(function () { 
  $('#bt_submit').click(function(e) {
     //e.preventDefault();
     
     if ( validar() ){
              document.formRec.submit();
        }
    /*  console.log("estou aqui no submit? ",  $("#formRec") );
     // $("#formRec").validate();
     $("#formRec").submit(function( event ) {
        alert( "Handler for .submit() called." );
       // event.preventDefault();
      }); 
      */
  }); 
   // $("#commentForm").validate();
});
    
</script>