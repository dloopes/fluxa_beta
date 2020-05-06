<?php
namespace Fluxa\View\Componente;

use Fluxa\View\Componente\IComponente;
use Fluxa\Entity\EnumRecursoStatus;

class CompSelectStatusRecurso implements IComponente {

	private $statusSelecionado;
	private $listaStatusRecurso;
	private $novaLinha;

    public function __construct($listaStatusRecurso, $statusSelecionado = null, $classColumn = "col-md-8", $novaLinha = true) {
    	$this->listaStatusRecurso = $listaStatusRecurso;
    	$this->statusSelecionado = $statusSelecionado;
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
					<label>Status *</label>
					<select class="form-control" name="status" id="status" required>								

						<?php
						if(empty($this->statusSelecionado)){
							?>
							<option value="" selected style="display: none;">Selecione o Status</option>
							<?php
						}
						?>

						<?php
						while(key($this->listaStatusRecurso) !== NULL ){
							
							$selected = $this->statusSelecionado == key($this->listaStatusRecurso);	

							if($selected){
								?>
								<option selected value=<?= key($this->listaStatusRecurso)?>><?= EnumRecursoStatus::getValueView(current($this->listaStatusRecurso))?></option></option>
								<?php
							}else{
								?>
								<option value=<?= key($this->listaStatusRecurso)?>><?= EnumRecursoStatus::getValueView(current($this->listaStatusRecurso))?></option>
								<?php
							}

							next($this->listaStatusRecurso);
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