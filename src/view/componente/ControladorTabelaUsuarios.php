<?php
namespace Fluxa\View\Componente;

use Fluxa\View\Componente\IControladorTabelaDados;
use Fluxa\Business\UsuarioBusiness;
use Fluxa\Business\RecursoBusiness;
use Fluxa\Entity\Recurso;

class ControladorTabelaUsuarios implements IControladorTabelaDados {

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
                return "Nome";
            case 1:
                return "Email";
            case 2:
                return "Necessidades";
            case 3:
                return "Ofertas";
            case 4:
                return "Total";
            case 5:
                return "Dt Cadastro";
            default:
                return '';
        }
    }

    public function getClasseColuna($indice) {
        switch ($indice) {
            case 0:
                return "col-xs-6 col-sm-6 col-md-4 col-lg-4 text-left";
            case 1:
                return "col-xs-6 col-sm-6 col-md-4 col-lg-4 text-left";
            case 2:
                return "hidden-xs hidden-sm col-md-1 col-lg-1 text-center";
            case 3:
                return "hidden-xs hidden-sm col-md-1 col-lg-1 text-center";
            case 4:
                return "hidden-xs hidden-sm col-md-1 col-lg-1 text-center";
            case 5:
                return "hidden-xs hidden-sm col-md-1 col-lg-1 text-center";
            default:
                return "";
        }
    }

    public function getValorColuna($registro, $indice) {

        $recursoBusiness = new RecursoBusiness();

        switch ($indice) {
            case 0:
                return "<a href='".URI_SISTEMA."usuario/".$registro->getId()."'>".$registro->getNome()."</a>";
            case 1:
                return $registro->getEmail();
            case 2:
                return $recursoBusiness->getQtdeTotalRecursosPorUsuario($registro->getId(), Recurso::TIPO_POSSIBILIDADE);
            case 3:
               return $recursoBusiness->getQtdeTotalRecursosPorUsuario($registro->getId(), Recurso::TIPO_POTENCIALIDADE);
            case 4:
               return $recursoBusiness->getQtdeTotalRecursosPorUsuario($registro->getId());
            case 5:
               return date('d/m/Y', strtotime($registro->getDataCadastro()));
            default:
                return "";
        }
    }

    public function getTotalColunas() {
        return 6;
    }
    
    public function getRegistroEditavel($registro){
    	return false;
    }
    
}

