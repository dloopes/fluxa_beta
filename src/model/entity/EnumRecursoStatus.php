<?php
namespace Fluxa\Entity;

use MyCLabs\Enum\Enum;

class EnumRecursoStatus extends Enum{
    
    const INDISPO = "INDISPO";
    const DISPO_RETIRA_LOCAL = "DISPO_RETIRA_LOCAL";
    const DISPO_ENTREGA = "DISPO_ENTREGA";
    const DISPO_USO_COMPART_LOCAL = "DISPO_USO_COMPART_LOCAL";    
    const DISPO_MEDIANTE_ACORDO = "DISPO_MEDIANTE_ACORDO";


    public static function getValueView($key){

        switch ($key) {
            case self::INDISPO:
                return "Não Disponível"; 
            case self::DISPO_RETIRA_LOCAL:
                return "Disponível retirada local"; 
            case self::DISPO_ENTREGA:
                return "Disponível para Entrega"; 
            case self::DISPO_USO_COMPART_LOCAL:
                return "Disponível para uso compartilhado no local"; 
            case self::DISPO_MEDIANTE_ACORDO:
                return "Disponível mediante acordo"; 
            default:
                return "";
        }
        
    }

}