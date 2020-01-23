<?php
namespace Fluxa\Persistence;

use \Slim\PDO\Database as PDO;
use \library\persist\connAccess;

class ArquivoDao{
    
     function garantePasta($pasta, $id_registro){
         
         $PATH_ANEXO = constant("K_PATH_FILES");
         
                                     if ( !is_dir($PATH_ANEXO . DIRECTORY_SEPARATOR . $pasta )){
                                         mkdir($PATH_ANEXO . DIRECTORY_SEPARATOR . $pasta );
                                     }
                                     if ( !is_dir($PATH_ANEXO . DIRECTORY_SEPARATOR . $pasta . DIRECTORY_SEPARATOR . $id_registro )){
                                         mkdir($PATH_ANEXO . DIRECTORY_SEPARATOR . $pasta  . DIRECTORY_SEPARATOR . $id_registro  );
                                     }  
                                     
                                     
                                     
    }
    public function getFolderByTabela($tipo, $id_registro ){
        
        $PATH_ANEXO = constant("K_PATH_FILES");
        return $PATH_ANEXO . DIRECTORY_SEPARATOR . $tipo  . DIRECTORY_SEPARATOR . $id_registro. DIRECTORY_SEPARATOR;
      
        
    }
    
    public function getList($oConn, $id_registro, $nome_tabela , $order_by = " order by id desc  "){
        $sql = "select * from arquivo where id_registro = ".$id_registro. " and id_tabela='".$nome_tabela."'  ".  $order_by;
        
        $itens =  connAccess::fetchData($oConn, $sql);

         $process = constant("BASE_THUMB_PROCESS");

         for ($i=0; $i < count( $itens) ; $i++) { 
                    $item = &$itens[$i];


                     if ( strpos(" ". $item["type"], "image") > 0 ){
                            
                                $item["url_thumb"] = $this->getURL($item, $item["arquivo"], $process, true);
                    }


                    $item["url"] = $this->getURL($item, $item["arquivo"], $process);

                }


                return $itens ;
    }
    
    
    public function deleteFile($oConn, $id ){
        
        $itens =  connAccess::fetchData($oConn, "select * from arquivo where id = " . $id );
        
        if ( count($itens) > 0 ){
            
            $item = (object)$itens[0];
            
            $arquivo = $item->arquivo;
            $tabela =  $item->id_tabela; 
            $pasta = $this->getFolderByTabela($tabela, $item->id_registro);
            if (file_exists($pasta.DIRECTORY_SEPARATOR.$arquivo)){
                unlink($pasta.DIRECTORY_SEPARATOR.$arquivo);
            }
            
            connAccess::executeCommand($oConn, " delete from arquivo where id = " . $id );
            
        }
        
        return true;
        
    }



       public function getURL( $item_ar, $arquivo, $process, $eh_thumb = false ){
           
           $item = (object)$item_ar;

           
            $base_path = constant("BASE_URL_ANEXO");
            
            if ( $base_path == ""){
               //   $base_path = storage_path();
            }
            
            $pasta = $item->id_tabela ;
            if ( $item->id_tabela == "inspecao_item"){
                $pasta = "itens";
            }
            
            if ( $eh_thumb ){
                
                    $minha_foto = "files/".$pasta."/".$item->id_registro."/". $arquivo."";
                            return $process . "?img=../../".$minha_foto."&x=280&y=150";
            }
            
            return $base_path."".$pasta."/".$item->id_registro."/".$arquivo;
           
       }


    public function getUrlArquivoCliente( $arquivo, $id_cliente ){
           
            $base_path = constant("BASE_URL_ANEXO");
            
            if ( $base_path == ""){
               //   $base_path = storage_path();
            }
            
            $pasta = "clientes";
            
            return $base_path."".$pasta."/".$id_cliente."/".$arquivo;
           
       }
}
