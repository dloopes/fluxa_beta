<?php
namespace Fluxa\View\Componente;

use Fluxa\View\Componente\IComponente;

class CompTabelaPaginacao implements IComponente {

    var $totalRegistros;

    var $qtdeRegPagina;

    var $qtdeBtnPagina;

    var $pagAtual;

    public function __construct($totalRegistros = NULL, $qtdeRegPagina = NULL, $qtdeBtnPagina = NULL, $pagAtual = NULL) {
        $this->totalRegistros = empty($totalRegistros) ? 0 : $totalRegistros;
        $this->qtdeRegPagina = empty($qtdeRegPagina) ? QDE_REG_PAG : $qtdeRegPagina;
        $this->qtdeBtnPagina = empty($qtdeBtnPagina) ? QDE_BTN_PAG : $qtdeBtnPagina;
        $this->pagAtual = empty($pagAtual) ? 1 : $pagAtual;
    }

    public function imprimeHTML() {
        
        // Obtém o número total de pagina
        if ($this->totalRegistros % $this->qtdeRegPagina > 0) {
            $numeroDePaginas = (int) ($this->totalRegistros / $this->qtdeRegPagina) + 1;
        } else {
            $numeroDePaginas = (int) ($this->totalRegistros / $this->qtdeRegPagina);
        }
        
        // Vamos preencher essa variável com o html da paginação
        $html = null;
        
        if ($this->pagAtual <= 3 || $numeroDePaginas <= 6) {
            $pagMin = 1;
        } else 
            if ($this->pagAtual > ($numeroDePaginas - 3)) {
                $pagMin = $numeroDePaginas - 5;
            } else {
                $pagMin = $this->pagAtual - 2;
            }
        
        $html .= "<div class='row' style='width: " . (($numeroDePaginas * 35) + 70) . "px; margin: 0 auto;'>";
        $html .= "<ul class='pagination'>";
        $html .= "<li>";
        
        // Primeira Pagina
        $html .= "<li><a href='1' aria-label='Previous'><span aria-hidden='true'>&laquo;</span></a></li>";
        
        // Faz o loop da paginação
        for ($i = $pagMin; $i < ($pagMin + $this->qtdeBtnPagina); $i ++) {
            
            // Eliminamos a primeira pagina (que seria a home do site)
            if ($i <= $numeroDePaginas && $i > 0) {
                
                // A pagina atual
                $pagina = $i;
                
                // Verifica qual dos números é a pagina atual
                if ($i == $this->pagAtual) {
                    $html .= "<li class='active'><a href='#'>$pagina</a></li>";
                } else {
                    $html .= "<li><a href='$pagina'>$pagina</a></li>";
                }
            }
        } // for
          
        // Ultima Pagina
        $html .= "<li><a href='$numeroDePaginas' aria-label='Next'><span aria-hidden='true'>&raquo;</span></a></li>";
        
        $html .= "</nav>";
        $html .= "</nav>";
        $html .= "</div>";
        
        // Retorna o que foi criado
        echo ($html);
    }
}