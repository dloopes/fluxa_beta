<?php
namespace Fluxa\View\Componente;

/*
 * Interface para padronizar controladores de tabela de dados
 */

/**
 *
 * @author Rodrigo Benedicto - 27/04/2016
 */
interface IControladorTabelaDados {

    public function getLinkNovo();

    public function getLinkEditar($idRegistro);

    public function getLinkExcluir($idRegistro);
    
    public function getRegistroEditavel($registro);

    public function getTotalRegistros();

    public function getNomeColuna($indice);

    public function getValorColuna($indice, $registro);

    public function getClasseColuna($indice);

    public function getTotalColunas();

    public function getPaginaAtual();
}

?>