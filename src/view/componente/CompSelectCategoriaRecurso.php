<?php
namespace Fluxa\View\Componente;

use Fluxa\View\Componente\IComponente;

class CompSelectCategoriaRecurso implements IComponente {

	private $categoriaSelecionada;
	private $listaCategorias;
	private $classColumn;
	private $novaLinha;

    public function __construct($listaCategorias, $categoriaSelecionada = null, $classColumn = "col-md-8", $novaLinha = true) {
    	$this->listaCategorias = $listaCategorias;
    	$this->categoriaSelecionada = $categoriaSelecionada;
    	$this->classColumn = $classColumn;
    	$this->novaLinha = $novaLinha;
    }
    
    public function imprimeHTML() {
    	
    	if($this->novaLinha){
    		?>
    		 <div class="row">
    		<?php
    	}

        ?>       
			<div class="<?=$this->classColumn?>">
				<div class="form-group">
					<label for="inputNome">Dimensão *</label>
					<select class="form-control" name="id_categoria" required>

						<?php
						if(empty($this->categoriaSelecionada)){
							?>
							<option value="" selected style="display: none;">Selecione a Dimensão</option>
							<?php
						}
						?>
						
						<?php
						foreach ($this->listaCategorias as $categoria){
							
							$selected = false;

							if(!empty($this->categoriaSelecionada)){
								$selected = $this->categoriaSelecionada->getId() == $categoria->getId();
							}

							if($selected){
								?>
								<option selected value=<?= $categoria->getId()?>><?= $categoria->getNome()?></option>
								<?php
							}else{
								?>
								<option value=<?= $categoria->getId()?>><?= $categoria->getNome()?></option>
								<?php
							}
							?>
							
							<?php 
						}
						?>
					</select>
				</div>
			</div>
		
		<?php		
		if($this->novaLinha){
    		?>
    		</div>
    		<?php
    	}

    }
}