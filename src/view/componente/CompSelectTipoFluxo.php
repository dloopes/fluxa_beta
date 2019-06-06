<?php
namespace Fluxa\View\Componente;

use Fluxa\View\Componente\IComponente;

class CompSelectTipoFluxo implements IComponente {

	private $tipoSelecionado;
	private $listaTiposFluxo;
	private $classColumn;
	private $novaLinha;

    public function __construct($listaTiposFluxo, $tipoSelecionado = null, $classColumn = "col-md-8", $novaLinha = true) {
    	$this->listaTiposFluxo = $listaTiposFluxo;
    	$this->tipoSelecionado = $tipoSelecionado;
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
					<label>Tipo de Fluxo *</label>
					<select class="form-control" name="tipo_fluxo" required>								

						<?php
						if(empty($this->tipoSelecionado)){
							?>
							<option value="" selected style="display: none;">Selecione o Tipo</option>
							<?php
						}
						?>

						<?php
						while(key($this->listaTiposFluxo) !== NULL ){
							
							$selected = $this->tipoSelecionado == key($this->listaTiposFluxo);	

							if($selected){
								?>
								<option selected value=<?= key($this->listaTiposFluxo)?>><?= current($this->listaTiposFluxo)?></option></option>
								<?php
							}else{
								?>
								<option value=<?= key($this->listaTiposFluxo)?>><?= current($this->listaTiposFluxo)?></option>	
								<?php
							}

							next($this->listaTiposFluxo);

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