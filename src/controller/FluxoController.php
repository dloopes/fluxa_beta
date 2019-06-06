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

class FluxoController {

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

	public function postFluxo($request, $response, $args) {

		$dadosRequest = $request->getParsedBody();

		$idRecurso = $dadosRequest['id_recurso'];

		if (empty($idRecurso)) {
			throw new ControlerException("Id do recurso é obrigatório");
		}

		$recurso = $this->recursoBusiness->buscarPorId($idRecurso, false);

		if (empty($recurso)) {
			throw new ControlerException("Recurso não encontrado");
		}

		$fluxo = new Fluxo();
		
		$fluxo->setViewUsuarioOferece(0);
		$fluxo->setIdRecurso($idRecurso);
		$fluxo->setStatus(Fluxo::STATUS_POTENCIAL);

		if($recurso->getTipo() == Recurso::TIPO_POTENCIALIDADE){
			$fluxo->setIdUsuarioOferece($recurso->getIdUsuario());
			$fluxo->setIdUsuarioNecessita($_SESSION['id']);
		}else{
			$fluxo->setIdUsuarioOferece($_SESSION['id']);
			$fluxo->setIdUsuarioNecessita($recurso->getIdUsuario());
		}		

		$fluxo = $this->fluxoBusiness->salvar($fluxo);

		//Enviar Email
		$this->emailBusiness->enviarEmailNovoFluxo($fluxo);

		//Gerando notificacao
		$this->notificacaoBusiness->geraNotificacaoNovoFluxo($fluxo);

		$_SESSION['msg_sucesso'] = "Fluxo gerado com sucesso";

		//return $response->withStatus(302)->withHeader('Location', URI_SISTEMA . 'mapa/recursos/'.$idRecurso);
		return $response->withStatus(302)->withHeader('Location', URI_SISTEMA . '/fluxo/'.$fluxo->getId());

	}

	public function postFluxoStatus($request, $response, $args) {

		$dadosRequest = $request->getParsedBody();

		$idFluxo = $dadosRequest['id_fluxo'];
		$opcaoSelecionada = $dadosRequest['opcao'];

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

			

			//Notificando outra parte de que o fluxo foi aceito
			$this->notificacaoBusiness->geraNotificacaoFluxoAceito($fluxo);

			$_SESSION['msg_sucesso'] = "Fluxado com sucesso";

		}else{

			// Não Fluxar
			$fluxo->setStatus(Fluxo::STATUS_INTERROMPIDO);
			$fluxo = $this->fluxoBusiness->salvar($fluxo);			

			//Notificando outra parte de que o fluxo foi aceito
			$this->notificacaoBusiness->geraNotificacaoFluxoRecusado($fluxo);

			$_SESSION['msg_sucesso'] = "Fluxo foi interrompido";

		}	

		//return $response->withStatus(302)->withHeader('Location', URI_SISTEMA . 'mapa/recursos/'.$idRecurso);
		return $response->withStatus(302)->withHeader('Location', URI_SISTEMA . '/fluxo/'.$fluxo->getId());

	}	

	public function getFluxo($request, $response, $args){

		$idFluxo = $request->getAttribute('id_fluxo');
		
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

		return $this->view->render($response, "TemplatePainel.php", [
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

		return $response->withStatus(302)->withHeader('Location', URI_SISTEMA . '/fluxo/'.$fluxo->getId());

	}

}