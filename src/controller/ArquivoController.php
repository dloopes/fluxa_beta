<?php
namespace Fluxa\Controller;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\UploadedFile;
use library\persist\connAccess;
use library\persist\PDOConnection;
use Fluxa\Controller\BaseController;


class ArquivoController  extends BaseController{
    

    
    
	private $view;
        public function __construct($view = null ) {
                        $this->view = $view;

        }
        function GUID()
          {
                      if (function_exists('com_create_guid') === true)
                      {
                          return trim(com_create_guid(), '{}');
                      }

                      return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535),
                              mt_rand(0, 65535), mt_rand(0, 65535),
                              mt_rand(16384, 20479), mt_rand(32768, 49151),
                              mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
          }


          public function index(Request  $request, Response  $response, $args)
          {

                      $dao = new \Fluxa\Persistence\ArquivoDAO();
                      $oConn = new \library\persist\PDOConnection(); 

                       $id_tabela =$request->getQueryParam('id_tabela');
                      //print_r( $id_tabela ); die(" " . $id_tabela);
                
                      $id_tabela = $request->getQueryParam("id_tabela");
                      $id_registro = $request->getQueryParam("id_registro");

                      $itens = $dao->getList($oConn , $id_registro,  $id_tabela );
                
                      return $this->sendResponse($response, array("data" =>  $itens  ) );
          }
          
          
              /**
                * Remove the specified resource from storage.
                *
                * @param  \App\Images  $images
                * @return \Illuminate\Http\Response
                */
               public function destroy(Request $request)
               {

                      $id = $request->getAttribute('id');
                      $dao = new \Fluxa\Persistence\ArquivoDAO();
                      $oConn = new \library\persist\PDOConnection(); 
                      
                      $reg = connAccess::fastOne($oConn, "arquivo", " id = ". $id );
                      
                      $dao->deleteFile($oConn, $id);

                      return array("code"=>1, "msg"=>"Exclusão realizada com sucesso!", "item" => $reg);

                }
                
                
                public function getTeste($request, $response, $args){
                    
                    return $this->view->render($response, "TemplatePainel.php", [
			"pagina" => "TesteArquivo.php"
			]);
                }
                
                
                function base64ToImage($base64_string, $output_file) {
                        $file = fopen($output_file, "wb");

                        $data = explode(',', $base64_string);

                        fwrite($file, base64_decode($data[1]));
                        fclose($file);

                        return $output_file;
                }
                
	         public function upload(Request  $request, Response  $response, $args)
                {


		      $post = $request->getParsedBody();
                      $uploadedFiles = $request->getUploadedFiles();
                      $base64 = false;

                      //$post =  $request->all();
                       $ano = date("Y"); $mes = date("m");
                       
                       //$zero_file = \Request::file('file0' );
                       
                       if (count($uploadedFiles) <= 0 )
                       {
                           $base64 = true;
                       }

                       if (count($uploadedFiles) <= 0 &&  $request->getParsedBodyParam("file0") == ""){
                           return $this->sendError($response, "file0 esta vazio", 400);
                       }
                       
                       
                      $file_qtde =   $request->getParsedBodyParam("file_qtde"); //$post[ "file_qtde"] ;//
                      $author_id =  $request->getParsedBodyParam("author_id"); //@$post[ "author_id"] ;//
                      $parent_id =  $request->getParsedBodyParam("parent_id"); //$post[ "parent_id"] ; //
                      $type_image = $request->getParsedBodyParam("type_image"); //$post[ "type_image"] ; // 
                      $tipo =    $request->getParsedBodyParam("tipo"); //  $post[ "tipo"];

                      if ( $type_image == "")
                          $type_image = "midia";
                      
                      $dao = new \Fluxa\Persistence\ArquivoDAO();
                      $oConn = new \library\persist\PDOConnection(); 
                      
                      $dao->garantePasta($tipo, $parent_id);
                      $pasta = $dao->getFolderByTabela($tipo, $parent_id);

                      $saida = array();
                      $saida_response = array();
                      $ids = "0 ";
                      for ( $i = 0; $i < $file_qtde; $i++ ){

                      $file = "";
                      $reg = array();
                      
                     
                      
                      if ( $base64 ) {
                          
                          $name_of_file = $request->getParsedBodyParam("file0_name");
                          $extensao = explode(".", $name_of_file );

                          $reg["arquivo"] =  str_replace("-","", $this->GUID()) . ".". $extensao[count($extensao) - 1 ];
                          $reg["titulo"] =  $name_of_file;
                          

                          $output_file =  $pasta .  $reg["arquivo"] ;
                          $file = $this->base64ToImage($request->getParsedBodyParam("file0"), $output_file);
                          
                          
                          $reg["tamanho"]  = filesize($output_file);
                          $reg["type"]  = mime_content_type($output_file);
                          
                      }else {
                          $file = $uploadedFiles['file'. $i]; // retorna o objeto em questão
                          
                           $reg["tamanho"]  = $file->getSize();
                           $reg["type"]  = $file->getClientMediaType();
                                    
                                    
                          $imageFileName = $file->getClientFilename();
                          $reg["titulo"] =  $imageFileName;
                                    
                          $name = explode(".", $imageFileName);
                          $ext = array_pop($name);
                          $ext = strtolower($ext);

                          $reg["arquivo"] =  str_replace("-","", $this->GUID()).".".$ext;
                                    
                          $file->moveTo( $pasta . $reg["arquivo"]);
                             
                          move_uploaded_file($file->file, $pasta . $reg["arquivo"]);
                      }
                      
                      $arr_metadados = array();
                      

                            if ( $parent_id != ""){
                                 $reg["id_registro"] = $parent_id;
                            }

                            $reg["id_tabela"]   = $tipo;
                                     
                                                                       
                                    connAccess::Insert($oConn, $reg, "arquivo", "id");

                         }
                         
                         //$oConn, $id_registro, $nome_tabela
                         $ls = $dao->getList($oConn, $parent_id, $tipo);
                         
                         return $this->sendResponse($response,  $ls );
                        // return json_encode($ls);

                }


}
?>