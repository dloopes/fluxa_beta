<?php
namespace Fluxa\Persistence;

use Fluxa\Entity\Fluxo;
use \Slim\PDO\Database as PDO;

class RecursoCadastroDAO {

	public function __construct() {

	}
        
        
            public static function salvarDadosJson($oConn, $recurso_id, $tipo,  $hd_json, $ids_delete_json ){
           
                            $itens = json_decode($hd_json);
                            $ids_delete = json_decode($ids_delete_json);

                            $qtde_salvo = 0; $qtde_delete = 0; $qtde_teste = 0;

                            for ( $i = 0; $i < count($itens); $i++){

                                        $item_req = $itens[$i];    
                                        
                                        $reg = array();


                                        if ( $item_req->id != ""){
                                              $reg["id"] = $item_req->id;
                                        }
                                              $reg["id_recurso"] = $recurso_id;
                                              $reg["tipo"] = $tipo; 
                                              $reg["descricao"] = $item_req->descricao; 
                                             // $reg->descrcicao = $item_req->descrcicao; 
                                              $reg["texto"] = $item_req->texto;   
                                              //$reg->texto = $item_req->texto;   

                                        \library\persist\connAccess::nullBlankColumns($reg);
                                        //ConfigDao::blankToNull($reg);
                                        
                                        if (!   @$reg["id"]){
                                               \library\persist\connAccess::Insert($oConn, $reg, "recurso_cadastros", "id");
                                            
                                        }else {
                                            
                                               \library\persist\connAccess::Update($oConn, $reg, "recurso_cadastros", "id");
                                        }

                                        $qtde_salvo++;
           }
           
           for ( $i = 0; $i < count($ids_delete); $i++){
               //$item_req = $ids_delete[$i];
               $id_delete = $ids_delete[$i];
               
                 if ( $item_req->id != ""){
                             $sql = " delete from recurso_cadastros where id_recurso = ". $recurso_id. " and tipo = '". $tipo."' and id = ". $id_delete;
                             \library\persist\connAccess::executeCommand($oConn, $sql);
                             $qtde_delete++;
                 }
           }
           
           return array("qtde_salvo" => $qtde_salvo, "qtde_deleted" => $qtde_delete , "success"=> true );
           
       }
}
