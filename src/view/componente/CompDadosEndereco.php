<?php
namespace Fluxa\View\Componente;

use Fluxa\View\Componente\IComponente;
use Fluxa\Entity\Endereco;

class CompDadosEndereco implements IComponente {

	private $endereco;

    public function __construct(Endereco $endereco) {
       $this->endereco = $endereco;
    }
    
    public function imprimeHTML() {
        ?>

        <div class="row">

        	<div class="col-md-2">
				<div class="form-group">
					<label>País *</label>
					<select class="form-control" name="pais" id="pais" required>	
						<option selected value="BRASIL">Brasil</option>
						<option value="MEXICO">México</option>							
					</select>
				</div>	
			</div>			

			<div class="col-md-2">
				<div class="form-group">
					<label for="cep">CEP *</label>
		        	<input name="cep" type="text" id="cep" value="<?= $this->endereco->getCep()?>" class="form-control"  placeholder="Informe o CEP" required/>
		        </div>
	        </div>

		</div>	

		<div class="row">	

		 	<div class="col-md-6">
	        	<div class="form-group">
		        	<label for="logradouro">Logradouro</label>
		        	<input name="logradouro" type="text" id="logradouro" value="<?= $this->endereco->getLogradouro()?>" class="form-control" required/>
		        </div>
		    </div>

		     <div class="col-md-2">
	        	<div class="form-group">
		        	<label for="numero">Número *</label>
		        	<input name="numero" type="text" id="numero" value="<?= $this->endereco->getNumero()?>" class="form-control" required />
		        </div>
		    </div>	

		</div>	
				
		<div class="row">	

			 <div class="col-md-4 ">
		        <div class="form-group">
		        	<label for="complemento">Complemento</label>
	        		<input name="complemento" type="text" id="complemento" value="<?= $this->endereco->getComplemento()?>" class="form-control"/>
	        	</div>
	       	</div>

		    <div class="col-md-4 ">
		        <div class="form-group">
		        	<label for="bairro">Bairro</label>
	        		<input name="bairro" type="text" id="bairro" value="<?= $this->endereco->getBairro()?>" class="form-control" required/>
	        	</div>
	       	</div>

       	</div>		
		
		<div class="row">

	        <div class="col-md-4">
	        	<div class="form-group">					        	
	        		<label>Cidade</label>
	        		<input name="cidade" type="text" id="cidade" value="<?= $this->endereco->getCidade()?>" class="form-control" readonly="true"/>
	        	</div>
	        </div>

	        <div class="col-md-4">
	        	<div class="form-group">	
	        		<label>Estado</label>
	        		<input name="uf" type="text" id="uf"  value="<?= $this->endereco->getEstado()?>" class="form-control" readonly="true"/>
        		</div>
        	</div>

		</div>	

		<script type="text/javascript">   

			$(document).ready(function() {

			    function limpa_formulário_cep() {
			        // Limpa valores do formulário de cep.
			        $("#logradouro").val("");
			        $("#bairro").val("");
			        $("#cidade").val("");
			        $("#uf").val("");
			        //$("#ibge").val("");
			    }

			    $("#pais").change(function(){
			    	$("#cep").val("");
			    	limpa_formulário_cep();
			    });
			    
			    //Quando o campo cep perde o foco.
			    $("#cep").blur(function() {

			        //Nova variável "cep" somente com dígitos.
			        var cep = $(this).val().replace(/\D/g, '');
			        var paisSelecionado = $("#pais").val();

			        //Verifica se campo cep possui valor informado.
			        if (cep != "") {

			            //Expressão regular para validar o CEP.
			            var validacep = /^[0-9]{8}$/;

		                //Preenche os campos com "..." enquanto consulta webservice.
		                $("#logradouro").val("...");
		                $("#bairro").val("...");
		                $("#cidade").val("...");
		                $("#uf").val("...");
		                //$("#ibge").val("...");

		                //var paisSelecionado = "MEXICO"
		                    	
		                if(paisSelecionado === "BRASIL"){
		                	 //Valida o formato do CEP.
		                	if(validacep.test(cep)) {
			                	//Consulta o webservice viacep.com.br/
			               		$.getJSON("//viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

				                    if (!("erro" in dados)) {
					                        //Atualiza os campos com os valores da consulta.
					                        $("#logradouro").val(dados.logradouro);
					                        $("#bairro").val(dados.bairro);
					                        $("#cidade").val(dados.localidade);
					                        $("#uf").val(dados.uf);
					                        //$("#ibge").val(dados.ibge);
				                    } else {
				                        //CEP pesquisado não foi encontrado.
				                        limpa_formulário_cep();
				                        showMessageAlert("CEP não encontrado.");
				                    }

			                	});
		               		}else {
				                //cep é inválido.
				                limpa_formulário_cep();
				                showMessageAlert("Formato de CEP inválido.");
				            }

		                }else{
		                	
		                	//Consulta o webservice viacep.com.br/
		               		$.getJSON("https://api-codigos-postales.herokuapp.com/v2/codigo_postal/"+ cep, function(dados) {

			                    if (dados.estado != "") {
				                        //Atualiza os campos com os valores da consulta.
				                        $("#logradouro").val("");
				                        $("#bairro").val(dados.bairro);
				                        $("#cidade").val(dados.municipio);
				                        $("#uf").val(dados.estado);
				                        //$("#ibge").val(dados.ibge);
			                    } else {
			                        //CEP pesquisado não foi encontrado.
			                        limpa_formulário_cep();
			                        showMessageAlert("CEP não encontrado.");
			                    }

		                    });			                    	
			                    
		                }
		               
		            } //end if.

		    	});

			});

		</script>

		<?php
    }
}