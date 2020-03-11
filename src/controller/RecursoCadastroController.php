<?php
namespace Fluxa\Controller;

use Fluxa\Entity\Recurso;
use Fluxa\Entity\Endereco;
use Fluxa\Entity\EnumRecursoStatus;
use Fluxa\Entity\EnumTiposFluxo;
use Fluxa\Business\RecursoBusiness;
use Fluxa\Business\RecursoCategoriaBusiness;
use Fluxa\Business\EnderecoBusiness;
use Fluxa\Exception\BusinessException;
use Fluxa\Exception\ControlerException;
use Fluxa\Controller\BaseController;

class RecursoCadastroController extends BaseController{
    
    
	private $view;
    public function __construct($view) {
		$this->view = $view;
    }
    public function listgrid($request, $response, $args) {
        
               
                      $oConn = new \library\persist\PDOConnection(); 
        
        	        $filtro = "";
			
			$dadosRequest = $request->getParsedBody();	
                        $recurso_id = $request->getQueryParam('recurso_id');
                        $tipo = $request->getQueryParam('tipo');
                        
                        if ( $recurso_id == ""){
                               $recurso_id = $request->getParsedBodyParam('recurso_id');
                               $tipo = $request->getParsedBodyParam('tipo');
                        }
				 
                        $order = "id"; $order_type = "asc";


                        $filtro .= " and p.id_recurso = ". $recurso_id . " and tipo='".$tipo."' ";


                        $sql = "select p.* from recurso_cadastros p where 1 = 1 ". $filtro .
                                        " order by ".$order. " ".$order_type;

                         $itens = \library\persist\connAccess::fetchData($oConn, $sql);


                         $saida = array("data"=>$itens, "qtde" => count($itens));
                        // return  $saida;
                         
                      return $this->sendResponse($response,  $saida);
				
        
    }
    
    public function salvargrid($request, $response, $args){
				
               
                      $oConn = new \library\persist\PDOConnection(); 
        
			$dadosRequest = $request->getParsedBody();	
				$hd_json = $request->getParsedBodyParam( "hd_json" )  ; 
				$json_delete = $request->getParsedBodyParam( "ids_delete_json" ); //  $request->input( "ids_delete_json");
                                 $recurso_id = $request->getParsedBodyParam('recurso_id');
                                 $tipo = $request->getParsedBodyParam('tipo');
				
				$ret = \Fluxa\Persistence\RecursoCadastroDAO::salvarDadosJson($oConn, $recurso_id, $tipo, $hd_json, $json_delete);
				
				$itens = $this->listgrid($request, $response, $args);
				
                      return $this->sendResponse($response,  $itens);
    }
    
    
}