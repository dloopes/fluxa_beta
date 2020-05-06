<?php
namespace Fluxa\View\Componente;

use Fluxa\View\Componente\IComponente;
use Fluxa\View\Componente\IControladorTabelaDados;
use Fluxa\View\Componente\IItemTabelaDados;
use Fluxa\View\Componente\CompTabelaPaginacao;

class CompTabelaDados implements IComponente {

    protected $controlador;

    protected $listaRegistros;

    protected $paginaAtual;

    protected $totalRegistros;

    protected $mostraBtnExcluir = true;

    protected $mostraBtnEditar = true;

    protected $mostraBtnNovo = true;
    
    protected $mostraBtnVisualizar = false; 
    
    protected $mensagemListaVazia = "Lista Vazia";
    
    protected $paginacaoAtiva = true;
    
    protected $nenhumaOpcaoAtiva = false;

    public function __construct($paginaAtual, IControladorTabelaDados $controlador) {
        $this->paginaAtual = $paginaAtual;
        $this->controlador = $controlador;
        
    }

    public function setItens($itens) {
        if (count($itens) > 0) {
        	if($this->paginacaoAtiva && count($itens) > QDE_REG_PAG){
	            $paginas = array_chunk($itens, QDE_REG_PAG);
	            $this->totalRegistros = count($itens);
	            $this->listaRegistros = $paginas[$this->paginaAtual - 1];
        	}else{
            	$this->listaRegistros = $itens;
            }
        }
    }

    public function setMostraBtnExcluir($valor) {
        $this->mostraBtnExcluir = $valor;
    }

    public function setMostraBtnEditar($valor) {
        $this->mostraBtnEditar = $valor;
    }

    public function setMostraBtnNovo($valor) {
        $this->mostraBtnNovo = $valor;
    }

    public function setMostraBtnSelecionar($valor) {
        $this->mostraBtnSelecionar = $valor;
    }
    
    public function setMostraBtnVisualizar($valor) {
    	$this->mostraBtnVisualizar = $valor;
    }
    
    public function setMensagemListaVazia($mensagem) {
    	$this->mensagemListaVazia = $mensagem;
    }
    
    public function desativarPaginacao(){
    	$this->paginacaoAtiva = false;
    }
    
    public function desativarTodasOpcoes(){
    	$this->setMostraBtnExcluir(false);
    	$this->setMostraBtnEditar(false);
    	$this->setMostraBtnNovo(false);
    	$this->setMostraBtnNovo(false);
    	$this->setMostraBtnSelecionar(false);
    	$this->setMostraBtnVisualizar(false);
    	$this->nenhumaOpcaoAtiva = true;
    }
    
    public function getControlador(){
    	return $this->controlador;
    }

    public function imprimeHTML() {
    	
        $this->pagAtual = $this->controlador->getPaginaAtual();   
             
        ?>
		<div class="col-xs-12">
		  	<div class="box">
				<div class="box-body table-responsive no-padding">
					<table class="table table-hover">
						<tr>
							<?php            
				            for ($i = 0; $i < $this->controlador->getTotalColunas(); $i ++) {
				                echo ("<th class='" . $this->controlador->getClasseColuna($i) . "' style='vertical-align: middle;'>" . $this->controlador->getNomeColuna($i) . "</th>");
				            }
	        
				            if(!$this->nenhumaOpcaoAtiva){
					            ?>
	            				<th style="min-width: 100px">
					            <?php 
						            if ($this->mostraBtnNovo) {
						                ?>
										<button onclick="location.href=<?php echo("'".$this->controlador->getLinkNovo()."'") ?>" type="button" class="btn btn-success" title="Cadastrar novo item">
											<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Novo
										</button>
										<?php
						            }
						            ?>
					            </th>
					            <?php 
				            }
				            ?>
						</tr>
						<?php
						if (count($this->listaRegistros) > 0) {
	            			foreach ($this->listaRegistros as $registro) {
		                		?>
								<tr>
								<?php
					                
					                for ($i = 0; $i < $this->controlador->getTotalColunas(); $i ++) {
					                    echo ("<td class='" . $this->controlador->getClasseColuna($i) . "' style='vertical-align: middle;'>" . $this->controlador->getValorColuna($registro, $i) . "</td>");
					                }
					                
					                if(!$this->nenhumaOpcaoAtiva){					                	
		                				?>
										<td class="col-xs-1 col-sm-1 col-md-1 col-lg-1">											
											<?php
											if ($this->controlador->getRegistroEditavel($registro) && $this->mostraBtnEditar) {
											?>
												<button type="button" onclick="location.href=<?php echo("'".$this->controlador->getlinkEditar($registro->getId())."'")?>" class="btn btn-default btn-sm" title="Editar">
													<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
												</button>
											<?php
							                }else if($this->mostraBtnVisualizar){
							                ?>
												<button type="button" onclick="location.href=<?php echo("'".$this->controlador->getlinkEditar($registro->getId())."'")?>" class="btn btn-default btn-sm" title="Visualizar">
													<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
												</button>
											<?php
						                	}
			                
							                if ($this->mostraBtnExcluir) {
							                    ?>
												<button type="button" onclick="showMessageConf('Deseja realmente excluir item?', <?php echo("'".$this->controlador->getlinkExcluir($registro->getId())."'")?>)" class="btn btn-default btn-sm" title="Excluir">
													<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
												</button>
											<?php
							                }
						                	?>
										</td>
										<?php 
						            }
						            ?>
								</tr>
							<?php
				            }
						}else{
							?>
							<tr>
								<td colspan="12"><?php echo($this->mensagemListaVazia) ?></td>
							</tr>
							<?php
						}
			            ?>
					</table>
				</div>
			</div>
		</div>
		<?php
        
        if ($this->totalRegistros > 0 && $this->totalRegistros > QDE_REG_PAG && $this->paginacaoAtiva) {
            $paginacao = new CompTabelaPaginacao($this->totalRegistros, QDE_REG_PAG, QDE_BTN_PAG, $this->controlador->getPaginaAtual());
            $paginacao->imprimeHTML();
        }
        ?>

	<?php
    }
}