<?php
namespace Fluxa\Persistence;

use Fluxa\Entity\Notificacao;
use \Slim\PDO\Database as PDO;

class NotificacaoDAO {

	public function __construct() {

	}

	public function salvar(Notificacao $notificacao) {

		if (empty($notificacao->getId())) {

			$strSQL = "INSERT INTO notificacao(texto, tipo, id_usuario, url) ";
			$strSQL .= "VALUES (:texto, :tipo, :id_usuario, :url)";

			$preSQL = ConexaoPDO::getInstance()->prepare($strSQL);

			$preSQL->bindValue(":texto", $notificacao->getTexto());
			$preSQL->bindValue(":tipo", $notificacao->getTipo());
			$preSQL->bindValue(":id_usuario", $notificacao->getIdUsuario());
			$preSQL->bindValue(":url", $notificacao->getUrl());

			$preSQL->execute();

			$notificacao->setId(ConexaoPDO::getInstance()->lastInsertId());

		} else {

			$strSQL = "UPDATE notificacao SET ";
			$strSQL .= "visualizado = :visualizado ";
			$strSQL .= "WHERE id = :id";

			$preSQL = ConexaoPDO::getInstance()->prepare($strSQL);

			$preSQL->bindValue(":visualizado", $notificacao->getVisualizado());
			$preSQL->bindValue(":id", $notificacao->getId());

			$preSQL->execute();

		}

		return $notificacao;

	}

	public function buscarPorIdUsuario($idUsuario, $visualizado = null) {

		$strSQL = "SELECT * FROM notificacao ";
		$strSQL .= "WHERE id_usuario = :id_usuario ";

		if(!empty($visualizado) OR $visualizado == 0){
			$strSQL .= "AND visualizado = :visualizado ";
		}

		$preSQL = ConexaoPDO::getInstance()->prepare($strSQL);

		$preSQL->bindValue(":id_usuario", $idUsuario);

		if(!empty($visualizado) OR $visualizado == 0){
			$preSQL->bindValue(":visualizado", $visualizado);
		}

		$preSQL->execute();

		return $preSQL->fetchAll(PDO::FETCH_CLASS, "Fluxa\Entity\Notificacao");

	}

	public function buscarPorId($id) {

		if (empty($id)) {
			return null;
		}

		$strSQL = "SELECT * FROM notificacao ";
		$strSQL .= "WHERE id = :id ";

		$preSQL = ConexaoPDO::getInstance()->prepare($strSQL);
		$preSQL->bindValue(":id", $id);

		$preSQL->execute();

		$result = $preSQL->fetchAll(PDO::FETCH_CLASS, "Fluxa\Entity\Notificacao");

		if (count($result) > 0) {
			return $result[0];
		}

		return null;

	}

	public function updateNotificacaoVisualizada($url, $idUsuario) {


		if (empty($url) || empty($idUsuario)) {
			return null;
		}

		$strSQL = "UPDATE notificacao SET ";
		$strSQL .= "visualizado = :visualizado ";
		$strSQL .= "WHERE id_usuario = :id_usuario ";
		$strSQL .= "AND url = :url";

		$preSQL = ConexaoPDO::getInstance()->prepare($strSQL);

		$preSQL->bindValue(":visualizado", true);
		$preSQL->bindValue(":url", $url);
		$preSQL->bindValue(":id_usuario", $idUsuario);

		$preSQL->execute();

	}


}

?>
