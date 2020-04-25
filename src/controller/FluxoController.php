<?php
namespace Fluxa\Controller;

use Fluxa\Business\RecursoBusiness;
use Fluxa\Business\FluxoBusiness;
use Fluxa\Business\NotificacaoBusiness;
use Fluxa\Business\FluxoMensagemBusiness;
use Fluxa\Business\EmailBusiness;
use Fluxa\Entity\Recurso;
use Fluxa\Entity\Fluxo;
use Fluxa\Entity\FluxoMensagem;
use Fluxa\Exception\BusinessException;
use Fluxa\Exception\ControlerException;	
use Fluxa\Controller\BaseController;

class FluxoController extends BaseController{

	private $view;
	private $recursoBusiness;
	private $fluxoBusiness;
	private $fluxoMensagemBusiness;
	private $notificacaoBusiness;
	private $emailBusiness;

	public function __construct($view) {
		$this->view = $view;
		$this->recursoBusiness = new RecursoBusiness();
		$this->fluxoBusiness = new FluxoBusiness();
		$this->fluxoMensagemBusiness = new FluxoMensagemBusiness();
		$this->notificacaoBusiness = new NotificacaoBusiness();
		$this->emailBusiness = new EmailBusiness();
	}

	function endsWith($string, $endString) 
	{ 
	    $len = strlen($endString); 
	    if ($len == 0) { 
	        return true; 
	    } 
	    return (substr($string, -$len) === $endString); 
	} 

	public function postFluxo($request, $response, $args) {

		$dadosRequest = $request->getParsedBody();

		$idRecurso = @$dadosRequest['id_recurso'];
		$retorno = @$dadosRequest['retorno'];
		$id_recurso_necessita = @$dadosRequest['id_recurso_necessita'];
                
            


		if (empty($idRecurso)) {
			throw new ControlerException("Id do recurso é obrigatório");
		}

		$recurso = $this->recursoBusiness->buscarPorId($idRecurso, false);

		if (empty($recurso)) {
			throw new ControlerException("Recurso não encontrado");
		}

		$fluxo = new Fluxo();

		$id_user_atual =  @$_SESSION['id'];

		if ( $id_user_atual == ""){
			$id_user_atual =  $dadosRequest['my_user_id'];
		}

		if (empty($id_user_atual)) {
			throw new ControlerException("Dados de usuário logado vazio.");
		}
		
		$fluxo->setViewUsuarioOferece(0);
		$fluxo->setIdRecurso($idRecurso);
		$fluxo->setStatus(Fluxo::STATUS_POTENCIAL);

		$fluxo->id_recurso_necessita = $id_recurso_necessita;
                
                if ( $id_recurso_necessita == ""){
                    
		       $fluxo->id_recurso_necessita = null;
                }
                
                $fluxo->setIdUsuarioOferece($recurso->getIdUsuario());
		$fluxo->setIdUsuarioNecessita($id_user_atual);
                
         
		 if($recurso->getTipo() == Recurso::TIPO_POTENCIALIDADE){
			$fluxo->setIdUsuarioOferece($recurso->getIdUsuario());
			$fluxo->setIdUsuarioNecessita($id_user_atual);
		}else if ($recurso->getTipo() == Recurso::TIPO_POSSIBILIDADE) {
		       	$fluxo->setIdUsuarioOferece($id_user_atual);
		 	$fluxo->setIdUsuarioNecessita($recurso->getIdUsuario());
		}
                 
                		

		if($recurso->getTipo() == Recurso::TIPO_INICIATIVA || $id_recurso_necessita  != ""){

	                $fluxo->setIdUsuarioOferece($recurso->getIdUsuario());
			$fluxo->setIdUsuarioNecessita($id_user_atual);
		}

		$fluxo = $this->fluxoBusiness->salvar($fluxo);
                
                $this->limpaBrancoStatusDoFluxo($fluxo->getId());

		//Enviar Email
		$this->emailBusiness->enviarEmailNovoFluxo($fluxo);

		//Gerando notificacao
		$this->notificacaoBusiness->geraNotificacaoNovoFluxo($fluxo);

		if ( $fluxo->getStatus() == "" ){
			
            
                           $oConn = new \library\persist\PDOConnection();
                           \library\persist\connAccess::executeCommand($oConn, "update fluxo set status='".Fluxo::STATUS_POTENCIAL. "' where id = ". $fluxo->getId() );
		}

		if ( $retorno == "json"){

			$str_url = URI_SISTEMA;

			if ( $this->endsWith($str_url, "/")){
				$str_url .= 'fluxo/'.$fluxo->getId();
			}else{
				$str_url .= '/fluxo/'.$fluxo->getId();
			}



				        $saida = array(
		                             "id_recurso"=> $fluxo->getId(),
		                             "id_fluxo"=> $fluxo->getId(),
		                             "url" => $str_url,
                                             "status"=>$fluxo->getStatus() != "" ? $fluxo->getStatus() : Fluxo::STATUS_POTENCIAL
		                            // "sql" => $sql
		                        );
		                         
		                return $this->sendResponse($response, $saida); 

		}
	
		$_SESSION['msg_sucesso'] = "Fluxo gerado com sucesso";

		//return $response->withStatus(302)->withHeader('Location', URI_SISTEMA . 'mapa/recursos/'.$idRecurso);
		return $response->withStatus(302)->withHeader('Location', URI_SISTEMA . '/fluxo/'.$fluxo->getId());

	}
        
        
        public function limpaBrancoStatusDoFluxo($idFluxo){
            
            $oConn = new \library\persist\PDOConnection();
            if ( $idFluxo != ""){
                $idtmp = \library\persist\connAccess::executeScalar($oConn, "select id as res from fluxo where id = ". $idFluxo. " and ifNull(status,'') = '' ");
        
                if ( $idtmp != ""){
                    \library\persist\connAccess::executeCommand($oConn, "update fluxo set status='".Fluxo::STATUS_POTENCIAL. "' where id = ". $idtmp );
                }
            }
            
        }

	public function postFluxoStatus($request, $response, $args) {

		$dadosRequest = $request->getParsedBody();

		$idFluxo = $dadosRequest['id_fluxo'];
		$opcaoSelecionada = $dadosRequest['opcao'];
		$clean = $dadosRequest['clean'];
                
                $this->limpaBrancoStatusDoFluxo($idFluxo);
                $oConn = new \library\persist\PDOConnection();
                

		if (empty($idFluxo)) {
			throw new ControlerException("Id do fluxo é obrigatório");
		}

		$fluxo = $this->fluxoBusiness->buscarPorId($idFluxo);

		if (empty($fluxo)) {
			throw new ControlerException("Fluxo não encontrado");
		}

		//Somente o usuário que recebeu o fluxo poderá aceitá-lo
		if($fluxo->getStatus() === Fluxo::STATUS_POTENCIAL){

			if($_SESSION['id'] !== $fluxo->getUsuarioRecebeuFluxo()->getId()){
				throw new ControlerException("Operação não permitida.");
			}

		}	
		
		if($opcaoSelecionada === "1"){
			
			// Fluxar
			$fluxo->setStatus(Fluxo::STATUS_REALIZADO);
			$fluxo = $this->fluxoBusiness->salvar($fluxo);

			
                       // die(" estou aqui ? ". $fluxo->getStatus(). " -- aa -- ". $opcaoSelecionada);

			//Notificando outra parte de que o fluxo foi aceito
			$this->notificacaoBusiness->geraNotificacaoFluxoAceito($fluxo);
                         \library\persist\connAccess::executeCommand($oConn, "update fluxo set status='".Fluxo::STATUS_REALIZADO. "' where id = ". $idFluxo );

			$_SESSION['msg_sucesso'] = "Fluxado com sucesso";

		}else{

			// Não Fluxar
			$fluxo->setStatus(Fluxo::STATUS_INTERROMPIDO);
			$fluxo = $this->fluxoBusiness->salvar($fluxo);	
                        \library\persist\connAccess::executeCommand($oConn, "update fluxo set status='".Fluxo::STATUS_INTERROMPIDO. "' where id = ". $idFluxo );		

			//Notificando outra parte de que o fluxo foi aceito
			$this->notificacaoBusiness->geraNotificacaoFluxoRecusado($fluxo);

			$_SESSION['msg_sucesso'] = "Fluxo foi interrompido";

		}	
                
                $strcomp = "";
                
                if ( $clean != ""){
                    $strcomp = "?clean=".$clean;
                }
                

		//return $response->withStatus(302)->withHeader('Location', URI_SISTEMA . 'mapa/recursos/'.$idRecurso);
		return $response->withStatus(302)->withHeader('Location', URI_SISTEMA . '/fluxo/'.$fluxo->getId(). $strcomp);

	}	

	public function getFluxo($request, $response, $args){

		$idFluxo = $request->getAttribute('id_fluxo');
		
                $this->limpaBrancoStatusDoFluxo($idFluxo);
		$fluxo = $this->fluxoBusiness->buscarPorId($idFluxo);

		$recurso = $this->recursoBusiness->buscarPorId($fluxo->getIdRecurso(), false);

		if($recurso->getTipo() == Recurso::TIPO_POTENCIALIDADE){
			$listaPossibilidades = array();
			$listaPotencialidades = array($recurso);
		}else{
			$listaPotencialidades = array();
			$listaPossibilidades = array($recurso);
		}

		$tipoRecurso = $recurso->getTipoFluxo();
		$nomeRecurso = $recurso->getNome();
		$endereco = $recurso->getEndereco();

		$listaMensagens = $this->fluxoMensagemBusiness->buscarPorIdFluxo($fluxo->getId());

		$podeEnviarMsg = false;

		if($fluxo->getIdUsuarioNecessita() == $_SESSION['id'] || $fluxo->getIdUsuarioOferece() == $_SESSION['id']){
			$podeEnviarMsg = true;
		}
                
                $url_template = "TemplatePainel.php";
                
                if ( @$args["clean"] || $request->getQueryParam('clean') == 1 ){
                    $url_template = "TemplateClean.php";
                }

		return $this->view->render($response, $url_template, [
			"pagina" => "CadastroFluxo.php",
			"fluxo" => $fluxo,
			"listaMensagens" => $listaMensagens,
			"listaPotencialidades" => $listaPotencialidades,
			"listaPossibilidades" => $listaPossibilidades,
			"nomeRecurso" => $nomeRecurso,
			"tipoRecurso" => $tipoRecurso,
			"latitudeDefault" => $endereco->getLatitude(),
			"longitudeDefault" => $endereco->getLongitude(),
			"zoomDefault" => 12,
			"recurso" => $recurso,
			"podeEnviarMsg" => $podeEnviarMsg,
			"mostraMsgAceitarFluxo" => true
			]);

	}

	public function getMeusFluxos($request, $response, $args){

		$numPag = $request->getAttribute('pag');

		if(empty($numPag)){
			$numPag = 1;
		}
		
		$listaFluxos = $this->fluxoBusiness->buscarPorUsuario();

		return $this->view->render($response, "TemplatePainel.php", [
			"pagina" => "MinhaListaFluxos.php",
			"listaFluxos" => $listaFluxos,
			"numPag" => $numPag
			]);

	}

	public function postFluxoMensagem($request, $response, $args) {

		$dadosRequest = $request->getParsedBody();

		$idFluxo = $dadosRequest['id_fluxo'];
		$texto = $dadosRequest['texto'];
		$clean = @$dadosRequest['clean'];

		if (empty($texto)) {
			throw new ControlerException("A mensagem é obrigatória");
		}

		$fluxo = $this->fluxoBusiness->buscarPorId($idFluxo);

		if($fluxo->getIdUsuarioNecessita() == $_SESSION['id'] && $fluxo->getIdUsuarioOferece() == $_SESSION['id']){
			throw new ControlerException("Problemas ao enviar mensagem.");
		}

		$usuarioDestinatario = null;

		if($fluxo->getUsuarioIniciouFluxo()->getId() != $_SESSION['id']){
			$usuarioDestinatario = $fluxo->getUsuarioIniciouFluxo();
		}else{
			$usuarioDestinatario = $fluxo->getUsuarioRecebeuFluxo();
		}

		$fluxoMensagem = new FluxoMensagem();

		$fluxoMensagem->setTexto($texto);
		$fluxoMensagem->setIdFluxo($fluxo->getId());
		$fluxoMensagem->setIdRemetente($_SESSION['id']);	
		$fluxoMensagem->setIdDestinatario($usuarioDestinatario->getId());	

		$fluxoMensagem = $this->fluxoMensagemBusiness->salvar($fluxoMensagem);

		$_SESSION['msg_sucesso'] = "Mensagem salva com sucesso";

		return $response->withStatus(302)->withHeader('Location', URI_SISTEMA . '/fluxo/'.$fluxo->getId()."?clean=".$clean);

	}
        
        function api_lista( $request, $response, $args ){
            
                      $oConn = new \library\persist\PDOConnection();
                      $dao = new  \Fluxa\Persistence\FluxoDAO();
                      
	             $id_recurso_pai = $request->getQueryParam('id_recurso');
                     
                    $lista = $dao->getListFilho($oConn, $id_recurso_pai) ;
                    
                    $saida = array(
                             "qtde"=> count($lista),
                             "data" => $lista ,
                            // "sql" => $sql
                        );
                         
                return $this->sendResponse($response, $saida);
        }

}