<?php
namespace Fluxa\View\Componente;

use Fluxa\View\Componente\IControladorTabelaDados;
use Fluxa\Business\UsuarioBusiness;
use Fluxa\Business\RecursoBusiness;
use Fluxa\Entity\Recurso;

class ControladorTabelaRecursos implements IControladorTabelaDados {

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
                return "Categoria";
            case 2:
                return "Local";
            default:
                return "";
        }
    }

    public function getClasseColuna($indice) {
        switch ($indice) {
            case 0:
                return "col-xs-5 col-sm-5 col-md-5 col-lg-5";
            case 1:
                return "col-xs-3 col-sm-3 col-md-3 col-lg-3";
            case 2:
                return "col-xs-4 col-sm-4 col-md-4 col-lg-4";
            default:
                return "";
        }
    }

    public function getValorColuna($registro, $indice) {

        $recursoBusiness = new RecursoBusiness();

        switch ($indice) {
            case 0:
                return "<a href='/sistema/mapa/recursos/".$registro->getId()."'>".$registro->getNome()."</a>";
                return $registro->getNome();
            case 1:
                return $registro->getCategoria()->getNome();
            case 2:
                return $registro->getEndereco()->getCidade()." - ".$registro->getEndereco()->getEstado();
            default:
                return "";
        }
    }

    public function getTotalColunas() {
        return 3;
    }
    
    public function getRegistroEditavel($registro){
    	return false;
    }
    
}

