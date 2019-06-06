<?php
namespace Fluxa\View\Componente;

use Fluxa\View\Componente\IControladorTabelaDados;
use Fluxa\Business\UsuarioBusiness;
use Fluxa\Business\FluxoBusiness;
use Fluxa\Entity\Fluxo;

class ControladorTabelaFluxos implements IControladorTabelaDados {

    private $pagAtual;

    public function __construct($pagAtual) {
        $this->pagAtual = $pagAtual;
    }

    public function getLinkNovo() {
        return '#';
    }

    public function getLinkEditar($id) {
        return '#';
    }

    public function getLinkExcluir($id) {
        return '#';
    }

    public function getTotalRegistros() {
        $business = new UsuarioBusiness();
        return $business->getTotalRegistros();
    }

    public function getPaginaAtual() {
        return $this->pagAtual;
    }

    public function getNomeColuna($indice) {
        switch ($indice) {
            case 0:
                return "Data";
            case 1:
                return "Fluxo";
            case 2:
                return "Status";
            default:
                return "";
        }
    }

    public function getClasseColuna($indice) {
        switch ($indice) {
            case 0:
                return "col-xs-2 col-sm-2 col-md-2 col-lg-2";
            case 1:
                return "col-xs-6 col-sm-6 col-md-6 col-lg-6";
            case 2:
                return "col-xs-3 col-sm-3 col-md-3 col-lg-3 text-center";
            case 3:
                return "col-xs-1 col-sm-1 col-md-1 col-lg-1";
            default:
                return "";
        }
    }

    public function getValorColuna($registro, $indice) {

        switch ($indice) {
            case 0:
                return date('d/m/y - H:i:s', strtotime($registro->getDateInsert()));
            case 1:
                return $registro->getMensagemDoFluxo();
            case 2:
                return $registro->getStatus();
            case 3:
                return '<a href="'.URI_SISTEMA . 'fluxo/'.$registro->getId().'" class="btn btn-default btn-sm" title="Ver no Detalhes">
                            <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                        </a>';
            default:
                return "";
        }
    }

    public function getTotalColunas() {
        return 4;
    }
    
    public function getRegistroEditavel($registro){
    	return false;
    }
    
}

