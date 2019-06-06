<?php
namespace Fluxa\Business;

use Fluxa\Exception\BusinessException;
use Fluxa\Entity\FluxoMensagem;
use Fluxa\Business\EmailBusiness;
use Fluxa\Persistence\FluxoMensagemDAO;

class FluxoMensagemBusiness {

	private $fluxoMensagemDAO;

	function __construct() {
		$this->fluxoMensagemDAO = new FluxoMensagemDAO();
	}

	public function salvar(FluxoMensagem $fluxoMensagem) {

		
		$fluxoMensagem = $this->fluxoMensagemDAO->salvar($fluxoMensagem);

		//Gerando notificacao
		$notificacaoBusiness = new NotificacaoBusiness();
		$notificacaoBusiness->geraNotificacaoNovoFluxoMensagem($fluxoMensagem);

		//Enviar Email
		$emailBusiness = new EmailBusiness();
		$emailBusiness->enviarEmailNovoFluxoMensagem($fluxoMensagem);

		return $fluxoMensagem;

	}

	public function buscarPorIdFluxo($idFluxo) {

		return $this->fluxoMensagemDAO->buscarPorIdFluxo($idFluxo);

	}

}