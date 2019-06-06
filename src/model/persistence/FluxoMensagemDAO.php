<?php
namespace Fluxa\Persistence;

use Fluxa\Entity\FluxoMensagem;
use \Slim\PDO\Database as PDO;

class FluxoMensagemDAO {

	public function __construct() {

	}

	public function salvar(FluxoMensagem $fluxoMensagem) {

		$strSQL = "INSERT INTO fluxo_mensagem(texto, id_fluxo, id_remetente, id_destinatario) ";
		$strSQL .= "VALUES (:texto, :id_fluxo, :id_remetente, :id_destinatario)";

		$preSQL = ConexaoPDO::getInstance()->prepare($strSQL);

		$preSQL->bindValue(":texto", $fluxoMensagem->getTexto());
		$preSQL->bindValue(":id_fluxo", $fluxoMensagem->getIdFluxo());
		$preSQL->bindValue(":id_remetente", $fluxoMensagem->getIdRemetente());
		$preSQL->bindValue(":id_destinatario", $fluxoMensagem->getIdDestinatario());

		$preSQL->execute();

		$fluxoMensagem->setId(ConexaoPDO::getInstance()->lastInsertId());

		return $fluxoMensagem;

	}

	public function buscarPorIdFluxo($idFluxo) {

		if(empty($idFluxo)){
			return null;
		}

		$strSQL = "SELECT * FROM fluxo_mensagem ";
		$strSQL .= "WHERE id_fluxo = :id_fluxo ";
		$strSQL .= "ORDER BY date_insert ASC ";

		$preSQL = ConexaoPDO::getInstance()->prepare($strSQL);

		$preSQL->bindValue(":id_fluxo", $idFluxo);

		$preSQL->execute();

		return $preSQL->fetchAll(PDO::FETCH_CLASS, "Fluxa\Entity\FluxoMensagem");

	}

}

?>
