<?php
namespace Fluxa\Business;

use Fluxa\Exception\BusinessException;
use Fluxa\Entity\Notificacao;
use Fluxa\Entity\Recurso;
use Fluxa\Entity\Fluxo;
use Fluxa\Entity\FluxoMensagem;
use Fluxa\Business\FluxoBusiness;
use Fluxa\Business\FluxoMensagemBusiness;
use Fluxa\Persistence\NotificacaoDAO;

class NotificacaoBusiness {

	private $notificacaoDAO;

	function __construct() {
		$this->notificacaoDAO = new NotificacaoDAO();
	}

	public function salvar(Notificacao $notificacao) {

		return $this->notificacaoDAO->salvar($notificacao);

	}

	public function buscarPorIdUsuario($idUsuario, $visualizado = null) {

		if(empty($idUsuario)){
			return null;
		}

		return $this->notificacaoDAO->buscarPorIdUsuario($idUsuario, $visualizado);
		
	}

	public function buscarPorId($idNotificacao) {

		if(empty($idNotificacao)){
			return null;
		}

		return $this->notificacaoDAO->buscarPorId($idNotificacao);
		
	}

	public function updateNotificacaoVisualizada($url){

		if(empty($url)){
			return null;
		}

		return $this->notificacaoDAO->updateNotificacaoVisualizada($url, $_SESSION['id']);

	}

	public function geraNotificacaoNovoFluxo(Fluxo $fluxo){

		if($fluxo->getIdUsuarioOferece()!= $_SESSION['id']){
			$idUsuario = $fluxo->getIdUsuarioOferece(); 
		}else{
			$idUsuario = $fluxo->getIdUsuarioNecessita();
		}

		if($fluxo->getRecurso()->getTipo() == Recurso::TIPO_POSSIBILIDADE){
			$texto = "Oferta de '".$fluxo->getRecurso()->getNome()."'";
		}else{
			$texto = "Pedido de '".$fluxo->getRecurso()->getNome()."'";			
		}

		$notificacao = new Notificacao($texto, "NOVO_FLUXO", $idUsuario, URI_SISTEMA . 'fluxo/'.$fluxo->getId());
		$this->salvar($notificacao);

		return true;

	}

	public function geraNotificacaoFluxoAceito(Fluxo $fluxo){

		$usuarioIniciouFluxo = $fluxo->getUsuarioIniciouFluxo();
		$usuarioRecebeuFluxo = $fluxo->getUsuarioRecebeuFluxo();

		$texto = $usuarioRecebeuFluxo->getNome()." está de acordo. (Fluxado)";

		$fluxoMensagem = new FluxoMensagem();
		$fluxoMensagem->setIdFluxo($fluxo->getId());
		$fluxoMensagem->setIdRemetente($usuarioRecebeuFluxo->getId());
		$fluxoMensagem->setIdDestinatario($usuarioIniciouFluxo->getId());
		$fluxoMensagem->setTexto("Estou de acordo. (Fluxado)");

		$fluxoMensagemBusiness = new FluxoMensagemBusiness();
		$fluxoMensagemBusiness->salvar($fluxoMensagem);

		$notificacao = new Notificacao($texto, "FLUXO_ACORDADO", $usuarioIniciouFluxo->getId(), URI_SISTEMA . 'fluxo/'.$fluxo->getId());
		$this->salvar($notificacao);

		return true;

	}

	public function geraNotificacaoFluxoRecusado(Fluxo $fluxo){

		$usuarioIniciouFluxo = $fluxo->getUsuarioIniciouFluxo();
		$usuarioRecebeuFluxo = $fluxo->getUsuarioRecebeuFluxo();

		$texto = $usuarioRecebeuFluxo->getNome()." interrompeu o fluxo.";

		$fluxoMensagem = new FluxoMensagem();
		$fluxoMensagem->setIdFluxo($fluxo->getId());
		$fluxoMensagem->setIdRemetente($usuarioRecebeuFluxo->getId());
		$fluxoMensagem->setIdDestinatario($usuarioIniciouFluxo->getId());
		$fluxoMensagem->setTexto($texto);
		$fluxoMensagem->setTexto("Interrompeu o fluxo.");

		$fluxoMensagemBusiness = new FluxoMensagemBusiness();
		$fluxoMensagemBusiness->salvar($fluxoMensagem);

		$notificacao = new Notificacao($texto, "FLUXO_INTERROMPIDO", $usuarioIniciouFluxo->getId(), URI_SISTEMA . 'fluxo/'.$fluxo->getId());
		$this->salvar($notificacao);

		return true;

	}

	public function geraNotificacaoNovoFluxoMensagem(FluxoMensagem $fluxoMensagem){

		$texto = "Nova mensagem de ".$_SESSION['nome'];

		$fluxoBusiness = new FluxoBusiness();
		$fluxo = $fluxoBusiness->buscarPorId($fluxoMensagem->getIdFluxo());

		if($fluxo->getIdUsuarioOferece()!= $_SESSION['id']){
			$idUsuario = $fluxo->getIdUsuarioOferece(); 
		}else{
			$idUsuario = $fluxo->getIdUsuarioNecessita();
		}

		$notificacao = new Notificacao($texto, "NOVA_MENSAGEM_FLUXO", $idUsuario, URI_SISTEMA . 'fluxo/'.$fluxoMensagem->getIdFluxo());
		
		$this->salvar($notificacao);

		return true;

	}

}