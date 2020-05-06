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
use Fluxa\Business\UsuarioBusiness;

class RecursoController extends BaseController{

	private $view;
	private $recursoBusiness;
	private $recursoCategoriaBusiness;
	private $enderecoBusiness;

	public function __construct($view) {
		$this->view = $view;
		$this->recursoBusiness = new RecursoBusiness();
		$this->recursoCategoriaBusiness = new RecursoCategoriaBusiness();
		$this->enderecoBusiness = new EnderecoBusiness();
	}

	public function postCadastroPotencialidade($request, $response, $args) {

		try{
			$dadosRequest = $request->getParsedBody();

			$id = $dadosRequest['id'];
			$nome = $dadosRequest['nome'];
			$detalhe = $dadosRequest['detalhe'];
			$idCategoria = $dadosRequest['id_categoria'];
			$status = $dadosRequest['status'];
			$tipoFluxo = $dadosRequest['tipo_fluxo'];

			$cep = @$dadosRequest['cep'];
			$logradouro = @$dadosRequest['logradouro'];
			$numero = @$dadosRequest['numero'];
			$complemento = @$dadosRequest['complemento'];
			$bairro = @$dadosRequest['bairro'];
			$cidade = @$dadosRequest['cidade'];
			$estado = @$dadosRequest['uf'];
			$pais = @$dadosRequest['pais'];
               
			if (empty($nome)) {
				throw new ControlerException("Nome é obrigatório");
			}

			if (empty($detalhe)) {
				throw new ControlerException("Detalhe é obrigatório");
			}

			if (empty($idCategoria)) {
				throw new ControlerException("Categoria é obrigatório");
			}

			if (empty($status)) {
				throw new ControlerException("Status é obrigatório");
			}

			if (empty($tipoFluxo)) {
				throw new ControlerException("Tipo do Fluxo é obrigatório");
			}

			/* if (empty($cep)) {
				throw new ControlerException("CEP é obrigatório");
			}

			if (empty($numero)) {
				throw new ControlerException("Número é obrigatório");
			}

			if (empty($logradouro) || empty($bairro) || empty($cidade) || empty($estado)) {
				throw new ControlerException("Informe um CEP válido");
			}
                         * */

			$recurso = new Recurso();

			if(!empty($id)){
				$recurso = $this->recursoBusiness->buscarPorId($id);							
			}

			/* $endereco = $recurso->getEndereco();	
			$endereco->setCep($cep);
			$endereco->setLogradouro($logradouro);
			$endereco->setNumero($numero);
			$endereco->setComplemento($complemento);
			$endereco->setBairro($bairro);
			$endereco->setCidade($cidade);
			$endereco->setEstado($estado);
			$endereco->setPais($pais);

			$endereco = $this->enderecoBusiness->salvar($endereco); */

			$recurso->setNome($nome);
			$recurso->setDetalhe($detalhe);
			$recurso->setIdCategoria($idCategoria);
			$recurso->setTipo(Recurso::TIPO_POTENCIALIDADE);
			$recurso->setIdUsuario($_SESSION['id']);
			$recurso->setStatus($status);
			$recurso->setTipoFluxo($tipoFluxo);
                        
                        
                        $hd_endereco_data = @$dadosRequest['hd_endereco_data'];
			$hd_form_data = @$dadosRequest['hd_form_data'];
                        
                        if ( $hd_form_data != ""){
                            
                             $api_form = json_decode($hd_form_data);
                             
                             if ( $api_form->tipo_endereco == "V"){
                              //endereco virtual   
                        
                             }else {
                                 
                                 if ( $hd_endereco_data != "" ){
                                     
                                     $endereco_data = json_decode(  $hd_endereco_data );
                                     //print_r( $endereco_data );die(" ");
                                     $res = \library\Api2::Call("enderecos", "POST", $endereco_data);
                                     //die("dei retorno no endereço? ". $res );
                                     $obj_retorno_endereco = json_decode($res);
			             $recurso->setIdEndereco( $obj_retorno_endereco->data->id );
                                 
                                 
                                 }
                                 
                                 
                             }
                        }
                        
                        
                        

			$this->recursoBusiness->salvar($recurso);
                        
                        
                        
                       $form_save = json_decode(  $hd_form_data );
                       $form_save->id = $recurso->getId();
                       $res = \library\Api2::Call("enderecos_virtual", "POST", $form_save);
                       //die("salvei pela segunda vez? ". $res2);

			if(!empty($id)){
				$_SESSION['msg_sucesso'] = "Registro alterado com sucesso";

				return $response->withStatus(302)->withHeader('Location', URI_SISTEMA . 'potencialidades');
			}else{
				$_SESSION['msg_sucesso'] = "Cadastro realizado com sucesso";
				$this->getCadastroPotencialidade($request, $response, $args);
			}			

		} catch (ControlerException $ce) {
			$_SESSION['msg_alerta'] = $ce->getMessage();
			$this->getCadastroPotencialidade($request, $response, $args);
		} 

	}

	public function getPotencialidades($request, $response, $args) {
		
		$listaPotencialidades = $this->recursoBusiness->buscarPotencialidades();

		return $this->view->render($response, "TemplatePainel.php", [
			"pagina" => "MinhaListaPotencialidade.php", 
			"listaPotencialidades" => $listaPotencialidades
			]);

	}

	public function getPotencialidadesAll($request, $response, $args) {

		$numPag = $request->getAttribute('pag');
		
		$listaPotencialidades = $this->recursoBusiness->buscarPotencialidades(false);

		return $this->view->render($response, "TemplatePainel.php", [
			"pagina" => "ListaPotencialidade.php",
			"listaPotencialidades" => $listaPotencialidades,
			"numPag" => $numPag
			]);

	}

	public function getCadastroPotencialidade($request, $response, $args) {

		$idRecurso = $request->getAttribute('id');

		$recurso = new Recurso();

		if(!empty($idRecurso)){
			$recurso = $this->recursoBusiness->buscarPorId($idRecurso);
		}

		$listaCategorias = $this->recursoCategoriaBusiness->buscarTodos();
		$listaStatus = EnumRecursoStatus::toArray();
		$listaTiposFluxo = EnumTiposFluxo::toArray();

		return $this->view->render($response, "TemplatePainel.php", [
			"pagina" => "CadastroPotencialidade.php", 
			"listaCategorias" => $listaCategorias,
			"listaStatus" => $listaStatus,
			"listaTiposFluxo" => $listaTiposFluxo,
			"recurso" => $recurso
			]);

	}

	public function getPossibilidadeInativar($request, $response, $args) {

		$idRecurso = $request->getAttribute('id');

		if(empty($idRecurso)){
			throw new ControlerException("Id do recurso é obrigatório");
		}

		$recurso = $this->recursoBusiness->buscarPorId($idRecurso);

		if(empty($recurso)){
			throw new ControlerException("Recurso não encontrado");
		}

		$recurso->setStatus(EnumRecursoStatus::INDISPO);

		$recurso = $this->recursoBusiness->salvar($recurso);

		$_SESSION['msg_sucesso'] = "Registro salvo com sucesso";
		$this->getPossibilidades($request, $response, $args);

	}

	public function postCadastroPossibilidade($request, $response, $args) {

		try{
			$dadosRequest = $request->getParsedBody();

			$id = $dadosRequest['id'];
			$nome = $dadosRequest['nome'];
			$detalhe = $dadosRequest['detalhe'];
			$idCategoria = $dadosRequest['id_categoria'];
			$status = $dadosRequest['status'];
			$tipoFluxo = $dadosRequest['tipo_fluxo'];

				$cep = @$dadosRequest['cep'];
			$logradouro = @$dadosRequest['logradouro'];
			$numero = @$dadosRequest['numero'];
			$complemento = @$dadosRequest['complemento'];
			$bairro = @$dadosRequest['bairro'];
			$cidade = @$dadosRequest['cidade'];
			$estado = @$dadosRequest['uf'];
			$pais = @$dadosRequest['pais'];

			if (empty($nome)) {
				throw new ControlerException("Nome é obrigatório");
			}

			if (empty($detalhe)) {
				throw new ControlerException("Detalhe é obrigatório");
			}

			if (empty($idCategoria)) {
				throw new ControlerException("Categoria é obrigatório");
			}

			if (empty($status)) {
				throw new ControlerException("Status é obrigatório");
			}

			if (empty($tipoFluxo)) {
				throw new ControlerException("Tipo de Fluxo é obrigatório");
			}

			/* if (empty($cep)) {
				throw new ControlerException("CEP é obrigatório");
			}

			if (empty($numero)) {
				throw new ControlerException("Número é obrigatório");
			}

			if (empty($logradouro) || empty($bairro) || empty($cidade) || empty($estado)) {
				throw new ControlerException("Informe um CEP válido");
			}
                         * */

			$recurso = new Recurso();

			if(!empty($id)){
				$recurso = $this->recursoBusiness->buscarPorId($id);							
			}

			/* $endereco = $recurso->getEndereco();	
			$endereco->setCep($cep);
			$endereco->setLogradouro($logradouro);
			$endereco->setNumero($numero);
			$endereco->setComplemento($complemento);
			$endereco->setBairro($bairro);
			$endereco->setCidade($cidade);
			$endereco->setEstado($estado);
			$endereco->setPais($pais);

			$endereco = $this->enderecoBusiness->salvar($endereco);
                         * */
                        

			$recurso = new Recurso();

			if(!empty($id)){
				$recurso = $this->recursoBusiness->buscarPorId($id);
			}

			$recurso->setNome($nome);
			$recurso->setDetalhe($detalhe);
			$recurso->setIdCategoria($idCategoria);
			$recurso->setTipo(Recurso::TIPO_POSSIBILIDADE);
			$recurso->setIdUsuario($_SESSION['id']);
			$recurso->setStatus($status);
			$recurso->setTipoFluxo($tipoFluxo);
			//$recurso->setIdEndereco($endereco->getId());
                        
                           
                        $hd_endereco_data = @$dadosRequest['hd_endereco_data'];
			$hd_form_data = @$dadosRequest['hd_form_data'];
                        $virtual = false;
                        
                        if ( $hd_form_data != ""){
                            
                             $api_form = json_decode($hd_form_data);
                             
                             if ( $api_form->tipo_endereco == "V"){
                              //endereco virtual   
                                 $virtual = true;
                        
                             }else {
                                 
                                 if ( $hd_endereco_data != "" ){
                                     
                                     $endereco_data = json_decode(  $hd_endereco_data );
                                     //print_r( $endereco_data );die(" ");
                                     $res = \library\Api2::Call("enderecos", "POST", $endereco_data);
                                     //die("dei retorno no endereço? ". $res );
                                     $obj_retorno_endereco = json_decode($res);
			             $recurso->setIdEndereco( $obj_retorno_endereco->data->id );
                                 
                                 
                                 }
                                 
                                 
                             }
                        }

			$this->recursoBusiness->salvar($recurso);
                        
                         $form_save = json_decode(  $hd_form_data );
                         $form_save->id = $recurso->getId();
                         $res2 = \library\Api2::Call("enderecos_virtual", "POST", $form_save);
                            
                         //die("salvei pela segunda vez? ". $res2);
                            
			if(!empty($id)){
				$_SESSION['msg_sucesso'] = "Registro alterado com sucesso";

				return $response->withStatus(302)->withHeader('Location', URI_SISTEMA . 'possibilidades');
			}else{
				$_SESSION['msg_sucesso'] = "Cadastro realizado com sucesso";
				$this->getCadastroPossibilidade($request, $response, $args);
			}			

		} catch (ControlerException $ce) {
			$_SESSION['msg_alerta'] = $ce->getMessage();
			$this->getCadastroPossibilidade($request, $response, $args);
		} 

	}

	public function getPossibilidades($request, $response, $args) {
		
		$listaPossibilidades = $this->recursoBusiness->buscarPossibilidades();

		return $this->view->render($response, "TemplatePainel.php", [
			"pagina" => "MinhaListaPossibilidade.php", 
			"listaPossibilidades" => $listaPossibilidades
			]);

	}

	public function getPossibilidadesAll($request, $response, $args) {

		$numPag = $request->getAttribute('pag');
		
		$listaPossibilidades = $this->recursoBusiness->buscarPossibilidades(false);

		return $this->view->render($response, "TemplatePainel.php", [
			"pagina" => "ListaPossibilidade.php",
			"listaPossibilidades" => $listaPossibilidades,
			"numPag" => $numPag
			]);

	}

	public function getCadastroPossibilidade($request, $response, $args) {

		$idRecurso = $request->getAttribute('id');

		$recurso = new Recurso();

		if(!empty($idRecurso)){
			$recurso = $this->recursoBusiness->buscarPorId($idRecurso);
		}

		$listaCategorias = $this->recursoCategoriaBusiness->buscarTodos();
		$listaStatus = EnumRecursoStatus::toArray();
		$listaTiposFluxo = EnumTiposFluxo::toArray();

		return $this->view->render($response, "TemplatePainel.php", [
			"pagina" => "CadastroPossibilidade.php", 
			"listaCategorias" => $listaCategorias,
			"listaStatus" => $listaStatus,
			"listaTiposFluxo" => $listaTiposFluxo,
			"recurso" => $recurso
			]);

	}
        
    
	public function getMapaRecursosId($request, $response, $args){
		
		$idRecurso = $request->getAttribute('id');

		$recurso = $this->recursoBusiness->buscarPorId($idRecurso, false);

		$listaPossibilidades = array();
		$listaPotencialidades = array();

		if(empty($recurso)){

			$_SESSION['msg_alerta'] = "Recurso não encontrado";

			return $this->view->render($response, "TemplatePainel.php", [
				"pagina" => "DetalheRecurso.php", 
				"listaPotencialidades" => $listaPotencialidades,
				"listaPossibilidades" => $listaPossibilidades
				]);
		
		}else{

			if($recurso->getTipo() == Recurso::TIPO_POTENCIALIDADE){			
				$listaPotencialidades = array($recurso);
			}else{			
				$listaPossibilidades = array($recurso);
			}

			$tipoRecurso = $recurso->getTipoFluxo();
			$nomeRecurso = $recurso->getNome();
			$endereco = $recurso->getEndereco();

			return $this->view->render($response, "TemplatePainel.php", [
				"pagina" => "DetalheRecurso.php", 
				"listaPotencialidades" => $listaPotencialidades,
				"listaPossibilidades" => $listaPossibilidades,
				"nomeRecurso" => $nomeRecurso,
				"tipoRecurso" => $tipoRecurso,
				"recurso" => $recurso,
				"latitudeDefault" => $endereco->getLatitude(),
				"longitudeDefault" => $endereco->getLongitude(),
				"zoomDefault" => 12,
				"recurso" => $recurso
				]);

		}	

		
	}
        
        
        
            private function loadRequests($request, &$reg){

                            $reg["nome"] = $request->getParsedBodyParam('nome');  
                            $reg["detalhe"] = $request->getParsedBodyParam('detalhe');  
                            $reg["tipo_recurso"] = $request->getParsedBodyParam('tipo_recurso');  
                            $reg["id_categoria"] = $request->getParsedBodyParam('id_categoria');  
                            $reg["status"] = $request->getParsedBodyParam('status');  
                            $reg["tipo_fluxo"] = $request->getParsedBodyParam('tipo_fluxo');
                            $reg["id_usuario"] = $GLOBALS["id_usuario_api"];
                            
                            \library\persist\connAccess::nullBlankColumns($reg);
	}
        
        
        public function api_index_associacao($request, $response, $args){
            
                      $oConn = new \library\persist\PDOConnection(); 
                      $dao = new \Fluxa\Persistence\RecursoDAO();
            
						$id_recurso_pai = $request->getQueryParam('id_recurso_pai');
						$tipo = $request->getQueryParam('tipo');
						$com_fluxo = $request->getQueryParam('com_fluxo');
						//die("com fluxo? ". $com_fluxo  );
					   //$oConn, $id_recurso_pai, $tipo = "", $id_recurso_necessita = "" , $com_fluxo = false 
					    $lista = $dao->getListFilho($oConn, $id_recurso_pai, $tipo, "", $com_fluxo);
               
                $saida = array(
                             "qtde"=> count($lista),
                             "data" => $lista ,
                            // "sql" => $sql
                        );
                         
                return $this->sendResponse($response, $saida); 
            
            
        }
        public function api_add_associacao($request, $response, $args){
            
                      $oConn = new \library\persist\PDOConnection(); 
                      $dao = new \Fluxa\Persistence\RecursoDAO();
                      
                            $id_recurso_pai = $request->getParsedBodyParam('id_recurso_pai');
                            $id_recurso_filho = $request->getParsedBodyParam('id_recurso_filho'); 
                            $tipo = $request->getParsedBodyParam('tipo'); 
                            $com_fluxo = $request->getParsedBodyParam('com_fluxo'); 
                            
                            $id_tmp =  $dao->adicionarFilho($oConn, $id_recurso_pai, $id_recurso_filho, $tipo);
                            
                            $lista = $dao->getListFilho($oConn, $id_recurso_pai, $tipo , "", $com_fluxo);
               
                            $saida = array(
                                         "qtde"=> count($lista),
                                         "data" => $lista ,
                                        // "sql" => $sql
                                    );

                            return $this->sendResponse($response, $saida); 
            
        }
         public function api_remove_associacao($request, $response, $args){
            
                      $oConn = new \library\persist\PDOConnection(); 
                      $dao = new \Fluxa\Persistence\RecursoDAO();
                      
                            $id = $request->getAttribute('id');
                            $id_recurso_pai = $request->getParsedBodyParam('id_recurso_filho'); 
                            $id_recurso_filho = $request->getParsedBodyParam('id_recurso_filho'); 
                            $tipo = $request->getParsedBodyParam('tipo'); 
                            
                            \library\persist\connAccess::executeCommand($oConn,"delete from recurso_associacao where id = ". $id );

                            return $this->sendResponse($response, array("code"=>1,"msg"=>"removido com sucesso!")); 
            
        }
        public function api_index($request, $response, $args){
               $id_usuario_api = $GLOBALS["id_usuario_api"];
	       $tipo_recurso = $request->getQueryParam('tipo_recurso');
	       $minhas = $request->getQueryParam('minhas');
	       $paginacao = $request->getQueryParam('paginacao');
	       $pagina = $request->getQueryParam('pagina');
	       $qtde_por_pagina = $request->getQueryParam('qtde_por_pagina');
               
               
                      $oConn = new \library\persist\PDOConnection(); 
                      $dao = new \Fluxa\Persistence\RecursoDAO();
                      $ArqDao = new \Fluxa\Persistence\ArquivoDAO();

                       $process = constant("BASE_THUMB_PROCESS");
            
               $filtro = "";
               $order = " id "; $order_type = "desc";
              
               if ( $request->getQueryParam( "filtro")  != ""){
                         	$str_filt = str_replace("'","''", $request->getQueryParam( "filtro") );
                        	$filtro .= " and ( p.nome like '%".$str_filt."%' or da.objetivo like '%".$str_filt."%' or da.categoria like '%".$str_filt."%' or ca.nome like '%".$str_filt."%' ) ";
               }
               
               if ( $tipo_recurso != ""){
                   $filtro .= " and  upper(p.tipo_recurso) = upper( '".$tipo_recurso."' ) ";
               }
               
               if ( $minhas == "1" && $id_usuario_api != ""){
                    $filtro .= " and  p.id_usuario= " . $id_usuario_api;
               }
               
               //$id_usuario_api
               
               $limitacao = ""; $qtde_total = 0;
               
               if ( $paginacao ){
                   $sql = "select count(*) as res 
                                from recurso p 
                                   left join recurso_dados da on da.id = p.id "
                        . "        left join recurso_categoria ca on ca.id = p.id_categoria
                                  where 1 = 1 ". $filtro;
                   $qtde_total = \library\persist\connAccess::executeScalar($oConn, $sql);
                   
                   if ( $qtde_por_pagina == ""){
                       $qtde_por_pagina= 10;
                   }
                   if ( $pagina == ""){
                       $pagina= 1;
                   }
                   $inicio = 0; $fim = 0;
                   
                   \library\PaginationService::SetaRsetPaginacao($qtde_por_pagina, $pagina, $qtde_total, $inicio, $fim);
                   $limitacao = " limit " . $inicio.", ".$qtde_por_pagina;
               }
               
               
                $sql = "select p.*, ca.nome as nome_dimensao, da.categoria, da.objetivo, da.recursos, '' as descricao_cat, '' as blnk "
                        . " from recurso p left join recurso_dados da on da.id = p.id "
                        . " left join recurso_categoria ca on ca.id = p.id_categoria "
                        . "  where 1 = 1 ". $filtro . " order by ".$order. " ".$order_type . $limitacao;
                $itens = \library\persist\connAccess::fetchData($oConn, $sql);
                
                  if (! $paginacao ){
                      $qtde_total = count($itens);
                      
		}
				  
		$listaStatus = $this->getListaStatus();
                for ( $i = 0; $i < count($itens); $i++ ){
					$item = &$itens[$i];
					
					$nome_staus = "A realizado";

                                        $nome_staus = \library\UtilService::getDescByCOD($listaStatus, "id", "nome",  $item["status"]);
                                        $item["status"] = $nome_staus;
                                        
                                        $descricao_cat = "";
                                         $ar = array_filter( explode(",", $item["categoria"]) );
                                            $ids_cat = join(",", $ar);

                                            if ( $ids_cat != ""){

                                            $sql = "select concat(codigo,' - ' , descricao ) as descr from cadastro_basico where id in ( " . $ids_cat . " ) ";
                                            $ls = @\library\persist\connAccess::fetchData($oConn, $sql);
                                            $descricao_cat = \library\UtilService::arrayToString($ls, "descr",", ");
                                            }
                                            
                                        $item["descricao_cat"] = $descricao_cat;
                                                //EnumRecursoStatus::getValueView($item["status"]);

                                        if ( $paginacao ){
                                            $lst_arquivo =  $ArqDao->getList($oConn, $item["id"], "recurso" ," and type like '%image%' order by id desc limit 0, 1 ");
                                            if ( count($lst_arquivo) > 0  ){
                                                    $item["image_url"] = $ArqDao->getURL( $lst_arquivo[0] , $lst_arquivo[0]["arquivo"],
                                                                       $process, true ); // $lst_arquivo[0]["arquivo"];
                                            }
                                        }
                                        
                                        //$reg_dados["categoria"]
                }
                
                
              
                $saida = array(
                             "qtde"=> count($itens),
                             "total"=>$qtde_total,
                             "data" => $itens ,
                        
                             "sql" => $sql
                        );
                         
                return $this->sendResponse($response, $saida);        
            
        }
        
          public function api_new(\Slim\Http\Request  $request, \Slim\Http\Response  $response, $args){
              
                      $oConn = new \library\persist\PDOConnection(); 
                      $dao = new \Fluxa\Persistence\RecursoDAO();
              	$listaCategorias = \library\persist\connAccess::fetchData($oConn, "select * from recurso_categoria order by nome ");
		        
                $listaStatusRecurso = EnumRecursoStatus::toArray();
                /* while(key($listaStatusRecurso) !== NULL ){
                    
								$listaStatus[count($listaStatus)]= array("id"=>key($listaStatusRecurso), "nome" => 
									EnumRecursoStatus::getValueView(current($listaStatusRecurso)) );
							
						next($listaStatusRecurso);
					}
				*/
				
				
				$listaStatus = $this->getListaStatus();
                
		        $listaTiposFluxo = EnumTiposFluxo::toArray();
                        
                        $lista_ods = \library\persist\connAccess::fetchData($oConn, "select id, codigo, descricao from cadastro_basico"
                                  . "  where id_tipo_cadastro_basico = 1 order by id asc ");
                          
                        $lista_cat = \library\persist\connAccess::fetchData($oConn, "select id, codigo, descricao from cadastro_basico"
                                  . "  where id_tipo_cadastro_basico = 2 order by id asc ");
                        
                         return $this->sendResponse($response, array("list_categorias" =>  $listaCategorias, "list_status" => $listaStatus , "lista_ods" => $lista_ods,
                                              "list_fluxo" => $listaTiposFluxo, "lista_cat" => $lista_cat) );
		  }
		  
		  public function getListaStatus(){

			$listaStatus = [
					  
				["id"=>"pendente", "nome"=>"A realizar"],
				["id"=>"realizado", "nome" =>"Realizado"],
				["id"=>"andamento", "nome" => "Em andamento"],
			];

			return $listaStatus;

		  }
          
          public function api_show_fluxos(\Slim\Http\Request  $request, \Slim\Http\Response  $response, $args)
          {

                      $oConn = new \library\persist\PDOConnection(); 
                      $dao = new \Fluxa\Persistence\RecursoDAO();
                      $daoArquivo = new \Fluxa\Persistence\ArquivoDAO();
                      
                      
                      $sql = " select f.* from fluxo f 
                                  left join recurso r on r.id = r.id_recurso
                                  left join usuario u on u.id = f.id_usuario_oferece
                                  left join usuario u2 on u2.id = f.id_usuario_necessita
                           where f.id_recurso = " . $this->request_slim($request, "id"). " order by f.id desc ";
                      
                      $ls = @\library\persist\connAccess::fetchData($oConn, $sql);
                      
                      return $this->sendResponse($response,array("data"=>$ls, "qtde" => count($ls)));
          }
       
          public function api_show(\Slim\Http\Request  $request, \Slim\Http\Response  $response, $args)
          {

                      $oConn = new \library\persist\PDOConnection(); 
                      $dao = new \Fluxa\Persistence\RecursoDAO();
                      $daoArquivo = new \Fluxa\Persistence\ArquivoDAO();
                      
			$usuarioBusiness = new UsuarioBusiness();
                      
		      $id = $request->getAttribute('id');
                      
                      
		      $reg = $dao->getByIdApi($oConn, $id); // RecursoDados::find($id);

                      $ls_arquivos = $daoArquivo->getList($oConn, $id, "recurso", " and type like '%image%' order by id asc ");
                      
                     // print_r( $reg );
                            $descricao_ods = ""; $descricao_cat = "";
                      if ( ! is_null($reg) && !is_null(@$reg["dados"])){
                            $ids_objetivo = @$reg["dados"]["objetivo_ods"];

                            if ( $ids_objetivo != "" ){

                                       $sql = "select concat(codigo,' - ' , descricao ) as descr from cadastro_basico where id in ( " . $ids_objetivo . " ) ";
                                       $ls = @\library\persist\connAccess::fetchData($oConn, $sql);
                                       $descricao_ods = \library\UtilService::arrayToString($ls, "descr","; ");

                            }
                            
                             $ids_cat = @$reg["dados"]["categoria"];
                                if ( $ids_cat != "" ){
                                       $ar = array_filter( explode(",", $ids_cat) );
                                       $ids_cat = join(",", $ar);
                                       
                                       if ( $ids_cat != ""){

                                       $sql = "select concat(codigo,' - ' , descricao ) as descr from cadastro_basico where id in ( " . $ids_cat . " ) ";
                                       $ls = @\library\persist\connAccess::fetchData($oConn, $sql);
                                       
                                       $descricao_cat = \library\UtilService::arrayToString($ls, "descr","; ");
                                       
                                                 //print_r( $ls );
                                           //  die(" ids cat? " . $sql );
                                       }

                            }
                      }
                      
                      
                      
		       $usuario = $usuarioBusiness->buscaUsuarioPorId($reg["id_usuario"] );
                       
                       $qtde_fluxos = @\library\persist\connAccess::executeScalar($oConn, "select count(*) from fluxo where id_recurso = ". $id);
                       if ( $qtde_fluxos == ""){
                           $qtde_fluxos = 0;
                       }
                       @$reg["qtde_fluxos"] = $qtde_fluxos;
                       
                       $user = 	array("data"=> strtotime(@$usuario->getDataCadastro()), "nome" => @$usuario->getNome(), "avatar" => @$usuario->getUrlImagem() ); 
                       
                      
                       $process = constant("BASE_THUMB_PROCESS");
                      if ( count($ls_arquivos) > 0 ){
                          $reg["image_url"] = $daoArquivo->getURL( (object)$ls_arquivos[0], $ls_arquivos[0]["arquivo"], $process, false);
                      }
                  //    return array( "code" =>  1,  "data"=> $reg, "item"=> $reg);
                      
                      @$reg["user"] = "";
                      $reg["user"] = $user;
                      
                      
                 return $this->sendResponse($response, array("item" =>  $reg, "data" => $reg,
                     "descricao_ods"=>$descricao_ods, "qtde_arquivos" => count($ls_arquivos), "user" => $user, "descricao_cat" => $descricao_cat )  );
          }
        
       
          public function api_store(\Slim\Http\Request  $request, \Slim\Http\Response  $response, $args)
          {

                      $oConn = new \library\persist\PDOConnection(); 
                      $dao = new \Fluxa\Persistence\RecursoDAO();
                      
                      $reg = array();
                      $reg_dados = array();
                      //$this->loadRequests( $request, $reg );
                      $dao->saveApi($oConn, $request, $reg, $reg_dados);
                      
                      //$reg["id"] = \library\persist\connAccess::Insert($oConn, $reg, "recurso", "id", true);
                      
                      
		      $item = $dao->getByIdApi($oConn, $reg["id"]);
                      
                      return $this->sendResponse($response, array("code" =>  1, "item" => $item) );
                      
          }
          
             
          public function api_edit($request, $response, $args){
              
                      $oConn = new \library\persist\PDOConnection(); 
                      $dao = new \Fluxa\Persistence\RecursoDAO();
                      
                      
		      $id = $request->getAttribute('id');
                      $reg = \library\persist\connAccess::fastOne($oConn, "recurso", " id = ". $id );
                      $reg_dados = \library\persist\connAccess::fastOne($oConn, "recurso_dados", " id = ". $id );
                      
                      $dao->saveApi($oConn, $request, $reg, $reg_dados);
                      
                      $item = $dao->getByIdApi($oConn, $reg["id"]);
                      
                      $hd_json = $request->getParsedBodyParam( "hd_json" )  ; 
		      $json_delete = $request->getParsedBodyParam( "ids_delete_json" ); //  $request->input( "ids_delete_json");
                      $recurso_id = $request->getParsedBodyParam('recurso_id');
                      $tipo = $request->getParsedBodyParam('tipo_rec_cadastro');
                      
                      if ( $tipo == ""){
                          $tipo = "contato";
                      }
				
		      $ret = \Fluxa\Persistence\RecursoCadastroDAO::salvarDadosJson($oConn, $recurso_id, $tipo, $hd_json, $json_delete);
                      
                      return $this->sendResponse($response, array("code" =>  1, "item" => $item) );
              
          }
          
              public function api_delete($request, $response, $args){
              
                      $oConn = new \library\persist\PDOConnection(); 
                      $dao = new \Fluxa\Persistence\RecursoDAO();
                      
                      
		      $id = $request->getAttribute('id');
                      $item = $dao->getByIdApi($oConn, $id);
                      $dao->deleteApi($oConn, $id);
                      
                      return $this->sendResponse($response, array("code" =>  1, "item" => $item) );
                      
              }
              public function request_slim($request, $prop){
                
                            $term = $request->getParsedBodyParam($prop);  
                            
                            if ( $term == ""){
                                
                                $term = $request->getQueryParam( $prop);
                            }
                            
                            return $term;
              }
              public function api_busca($request, $response, $args){
                  
                      $oConn = new \library\persist\PDOConnection(); 
                      $dao = new \Fluxa\Persistence\RecursoDAO();
                  //Request["term"].Replace("'", "")
                  
                            $retorno =  $this->request_slim($request, "retorno");
                            $term = str_replace("'","",
                                     $this->request_slim($request, "term")); // $request->getParsedBodyParam('term');
                            
                            $id_recurso_excluido = $this->request_slim($request, "id_recurso_excluido"); // $request->getParsedBodyParam('id_recurso_excluido');
                            
                            $sql = "select r.id, r.nome, r.tipo_recurso,  r.tipo_fluxo, rd.objetivo  from recurso r "
                                    . " left join recurso_dados rd on rd.id = r.id "
                                    . "  left join recurso_categoria ca on ca.id = r.id_categoria "
                                    . " where 1 = 1 ";
                            
                            if ( $id_recurso_excluido != ""){
                                $sql .= " and r.id not in ( ". $id_recurso_excluido." ) ";
                            }
                            
                            if ( $term != ""){
                                 $sql .= " and ( r.nome like '%".$term."%' or rd.objetivo "
                                         . " like '%".$term."%' or r.tipo_fluxo like '%".$term."%' or ca.nome like '%".$term."%' ) ";
                            }

                            $sql .= " and r.tipo_recurso in ('possibilidade', 'potencialidade' ) ";
                            
                            $sql .= " order by r.nome ";
                            
                            $itens = \library\persist\connAccess::fetchData($oConn, $sql);
                            
                            $saida = array();
                            for ( $i = 0; $i < count($itens); $i++ ){
                                $item = $itens[$i];

                                if ( $retorno == "array"){

                                	$str = "Oferta";

                                	//if ( $item["tipo_fluxo"] == "Compra")

                                	$saida[count($saida)] = array("id"=> $item["id"], "nome" =>strtoupper( $item["nome"]." - ".
                                		    $item["tipo_recurso"]." - ".
                                             EnumTiposFluxo::getValueView($item["tipo_fluxo"]) ));

                                }else {

                                     $saida[count($saida)] = $item["nome"]." - ".
                                             EnumTiposFluxo::getValueView($item["tipo_fluxo"])."|#|". $item["id"];
                                }
                        
                            }

                            if ( $retorno == "array"){
                                       return $this->sendResponse($response, array("data" => $saida, "qtde" => count($saida)) );

                            }
                            
                           
                      return $this->sendResponse($response, $saida );
                  
              }
        
        
        public function getViewMinhasIniciativas($request, $response, $args) {
            
            return $this->view->render($response, "TemplatePainel.php", [
			"pagina" => "MinhasIniciativas.php"
			]);
            
        }


        public function getViewListaIniciativas($request, $response, $args) {
            
            return $this->view->render($response, "TemplatePainel.php", [
			"pagina" => "ListaIniciativa.php"
			]);
            
        }


	public function getPotencialidadeInativar($request, $response, $args) {

		$idRecurso = $request->getAttribute('id');

		if(empty($idRecurso)){
			throw new ControlerException("Id do recurso é obrigatório");
		}

		$recurso = $this->recursoBusiness->buscarPorId($idRecurso);

		if(empty($recurso)){
			throw new ControlerException("Recurso não encontrado");
		}

		$recurso->setStatus(EnumRecursoStatus::INDISPO);

		$recurso = $this->recursoBusiness->salvar($recurso);

		$_SESSION['msg_sucesso'] = "Registro salvo com sucesso";

		$this->getPotencialidades($request, $response, $args);

	}

	public function getDiferentesNomesDeRecursos($request, $response, $args) {

		$params = $request->getQueryParams();

		$query = @$params['query'];

		$listaNomes = $this->recursoBusiness->buscaNomesRecurso($query);

		$recursos = array();

		foreach ($listaNomes as $itemLista) {

			$item['label'] = $itemLista['nome'];

			$recursos[] = $item;

		}

		return json_encode($recursos);

	}

	public function getMapaRecursos($request, $response, $args){
		
		$nomeRecurso = $request->getAttribute('nome');
		$tipoRecurso = null;

		$listaPotencialidades = array();
		$listaPossibilidades = array();

		switch ($request->getAttribute('tipo')) {
			case 'potencialidade':
				$tipoRecurso = Recurso::TIPO_POTENCIALIDADE;
				$listaPotencialidades = $this->recursoBusiness->buscarPorNome($nomeRecurso, Recurso::TIPO_POTENCIALIDADE);
				break;
			case 'possibilidade':
				$tipoRecurso = Recurso::TIPO_POSSIBILIDADE;
				$listaPossibilidades = $this->recursoBusiness->buscarPorNome($nomeRecurso, Recurso::TIPO_POSSIBILIDADE);
				break;
			default:
				break;
		}		

		return $this->view->render($response, "TemplatePainel.php", [
			"pagina" => "MapaRecursos.php", 
			"listaPotencialidades" => $listaPotencialidades,
			"listaPossibilidades" => $listaPossibilidades,
			"nomeRecurso" => $nomeRecurso,
			"tipoRecurso" => $tipoRecurso
			]);
	}


}