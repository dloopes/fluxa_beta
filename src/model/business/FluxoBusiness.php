<?php
namespace Fluxa\Business;

use Fluxa\Exception\BusinessException;
use Fluxa\Entity\Fluxo;
use Fluxa\Entity\Notificacao;
use Fluxa\Business\NotificacaoBusiness;
use Fluxa\Persistence\FluxoDAO;

class FluxoBusiness {

	private $daoFluxo;

	function __construct() {
		$this->daoFluxo = new FluxoDAO();
	}

	public function salvar(Fluxo $fluxo) {

		if (empty($fluxo)) {
			throw new BusinessException("Fluxo não pode ser nulos");
			return null;
		}

		$fluxo = $this->daoFluxo->salvar($fluxo);

		return $fluxo;

	}

	public function buscarPorUsuario($idUsuario = null) {

		if(empty($idUsuario)){
			$idUsuario = $_SESSION['id'];
		}

		$fluxos = $this->daoFluxo->buscarPorUsuario($idUsuario);

		return $fluxos;

	}

	public function buscarPorId($idFluxo) {

		if (empty($idFluxo)) {
			return null;
		}

		return $this->daoFluxo->buscarPorId($idFluxo);

	}

	public function getTotalQtdePorUsuario($idUsuario) {

		if(empty($idUsuario)){
			return null;
		}
		
		return $this->daoFluxo->getTotalQtdePorUsuario($idUsuario);

	}


}