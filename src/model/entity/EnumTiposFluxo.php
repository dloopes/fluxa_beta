<?php
namespace Fluxa\Entity;

use MyCLabs\Enum\Enum;

class EnumTiposFluxo extends Enum{
    
    const USO_COMPARTILHADO = "Uso Compartilhado";
    const DOACAO = "Doação";
    const TROCA = "Troca";
    const VENDA = "Venda";    
    const COMPRA = "Compra";
    const SINERGIA = "Sinergia";
    const CONTEUDO = "Conteúdo";
    const INICIATIVA = "Iniciativa";
    const ENCONTRO = "Encontro";
    const PROJETO = "Projeto";
    const MODELO = "Modelo";

    public static function getValueView($key){

        switch ($key) {
            case 'USO_COMPARTILHADO':
                return EnumTiposFluxo::USO_COMPARTILHADO; 
            case 'DOACAO':
                return EnumTiposFluxo::DOACAO; 
            case 'TROCA':
                return EnumTiposFluxo::TROCA; 
            case 'VENDA':
                return EnumTiposFluxo::VENDA; 
            case 'COMPRA':
                return EnumTiposFluxo::COMPRA; 
            case 'SINERGIA':
                return EnumTiposFluxo::SINERGIA; 
            case 'CONTEUDO':
                return EnumTiposFluxo::CONTEUDO; 
            case 'INICIATIVA':
                return EnumTiposFluxo::INICIATIVA;  
            case 'ENCONTRO':
                return EnumTiposFluxo::ENCONTRO; 
            case 'PROJETO':
                return EnumTiposFluxo::PROJETO; 
            case 'MODELO':
                return EnumTiposFluxo::MODELO; 
            default:
                return "";
        }
        
    }

}