<?php
namespace Fluxa\Persistence;

use Fluxa\Entity\Fluxo;
use \Slim\PDO\Database as PDO;

class FluxoDAO {

	public function __construct() {

	}

	public function salvar(Fluxo $fluxo) {

		if (empty($fluxo->getId())) {

			$strSQL = "INSERT INTO fluxo(id_usuario_oferece, id_usuario_necessita, id_recurso, status) ";
			$strSQL .= "VALUES (:id_usuario_oferece, :id_usuario_necessita, :id_recurso, :status)";

			$preSQL = ConexaoPDO::getInstance()->prepare($strSQL);

			$preSQL->bindValue(":id_usuario_oferece", $fluxo->getIdUsuarioOferece());
			$preSQL->bindValue(":id_usuario_necessita", $fluxo->getIdUsuarioNecessita());
			$preSQL->bindValue(":id_recurso", $fluxo->getIdRecurso());
			$preSQL->bindValue(":status", $fluxo->getStatus());

			$preSQL->execute();

			$fluxo->setId(ConexaoPDO::getInstance()->lastInsertId());

		} else {

			$strSQL = "UPDATE fluxo SET ";
			$strSQL .= "status = :status ";
			$strSQL .= "WHERE id = :id";

			$preSQL = ConexaoPDO::getInstance()->prepare($strSQL);

			$preSQL->bindValue(":status", $fluxo->getStatus());
			$preSQL->bindValue(":id", $fluxo->getId());

			$preSQL->execute();

		}

		return $fluxo;

	}

	public function buscarPorUsuario($idUsuario) {

		if(empty($idUsuario)){
			return null;
		}

		$strSQL = "SELECT * FROM fluxo ";
		$strSQL .= "WHERE id_usuario_necessita = :id_usuario1 ";
		$strSQL .= "OR id_usuario_oferece = :id_usuario2 ";
		$strSQL .= "ORDER BY id DESC ";

		$preSQL = ConexaoPDO::getInstance()->prepare($strSQL);

		$preSQL->bindValue(":id_usuario1", $idUsuario);
		$preSQL->bindValue(":id_usuario2", $idUsuario);

		$preSQL->execute();

		return $preSQL->fetchAll(PDO::FETCH_CLASS, "Fluxa\Entity\Fluxo");

	}

	public function buscarPorId($idFluxo, $idUsuario = null) {

		if (empty($idFluxo)) {
			return null;
		}

		$strSQL = "SELECT * FROM fluxo ";
		$strSQL .= "WHERE id = :id ";

		if(!empty($idUsuario)){
			$strSQL .= "AND id_usuario = :id_usuario ";	
		}

		$preSQL = ConexaoPDO::getInstance()->prepare($strSQL);
		$preSQL->bindValue(":id", $idFluxo);
		
		if(!empty($idUsuario)){
			$preSQL->bindValue(":id_usuario", $idUsuario);
		}

		$preSQL->execute();

		$result = $preSQL->fetchAll(PDO::FETCH_CLASS, "Fluxa\Entity\Fluxo");

		if (count($result) > 0) {
			return $result[0];
		}

		return null;

	}

	public function getTotalQtdePorUsuario($idUsuario) {

		if(empty($idUsuario)){
			return null;
		}

		$strSQL = "SELECT COUNT(*) FROM fluxo ";
		$strSQL .= "WHERE id_usuario_necessita = :id_usuario1 ";
		$strSQL .= "OR id_usuario_oferece = :id_usuario2 ";

		$preSQL = ConexaoPDO::getInstance()->prepare($strSQL);

		$preSQL->bindValue(":id_usuario1", $idUsuario);
		$preSQL->bindValue(":id_usuario2", $idUsuario);

		$preSQL->execute();

		return $preSQL->fetchColumn();

	}

}

?>
