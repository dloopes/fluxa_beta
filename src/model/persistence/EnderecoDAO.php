<?php
namespace Fluxa\Persistence;

use Fluxa\Entity\Endereco;
use \Slim\PDO\Database as PDO;

class EnderecoDAO {

	public function __construct() {

	}

	public function salvar(Endereco $endereco) {

		if (empty($endereco->getId())) {

			$strSQL = "INSERT INTO endereco(cep, logradouro, numero, complemento, bairro, cidade, estado, pais, latitude, longitude) ";
			$strSQL .= "VALUES (:cep, :logradouro, :numero, :complemento, :bairro, :cidade, :estado, :pais, :latitude, :longitude)";

			$preSQL = ConexaoPDO::getInstance()->prepare($strSQL);

			$preSQL->bindValue(":cep", $endereco->getCep());
			$preSQL->bindValue(":logradouro", $endereco->getLogradouro());
			$preSQL->bindValue(":numero", $endereco->getNumero());
			$preSQL->bindValue(":complemento", $endereco->getComplemento());
			$preSQL->bindValue(":bairro", $endereco->getBairro());
			$preSQL->bindValue(":cidade", $endereco->getCidade());
			$preSQL->bindValue(":estado", $endereco->getEstado());
			$preSQL->bindValue(":pais", $endereco->getPais());
			$preSQL->bindValue(":latitude", $endereco->getLatitude());
			$preSQL->bindValue(":longitude", $endereco->getLongitude());


			$preSQL->execute();

			$endereco->setId(ConexaoPDO::getInstance()->lastInsertId());

		} else {

			$strSQL = "UPDATE endereco SET ";
			$strSQL .= "cep = :cep, ";
			$strSQL .= "logradouro = :logradouro, ";
			$strSQL .= "numero = :numero, ";
			$strSQL .= "complemento = :complemento, ";
			$strSQL .= "bairro = :bairro, ";
			$strSQL .= "cidade = :cidade, ";
			$strSQL .= "estado = :estado, ";
			$strSQL .= "pais = :pais, ";
			$strSQL .= "latitude = :latitude, ";
			$strSQL .= "longitude = :longitude ";
			$strSQL .= "WHERE id = :id";

			$preSQL = ConexaoPDO::getInstance()->prepare($strSQL);

			$preSQL->bindValue(":cep", $endereco->getCep());
			$preSQL->bindValue(":logradouro", $endereco->getLogradouro());
			$preSQL->bindValue(":numero", $endereco->getNumero());
			$preSQL->bindValue(":complemento", $endereco->getComplemento());
			$preSQL->bindValue(":bairro", $endereco->getBairro());
			$preSQL->bindValue(":cidade", $endereco->getCidade());
			$preSQL->bindValue(":estado", $endereco->getEstado());
			$preSQL->bindValue(":pais", $endereco->getPais());
			$preSQL->bindValue(":id", $endereco->getId());
			$preSQL->bindValue(":latitude", $endereco->getLatitude());
			$preSQL->bindValue(":longitude", $endereco->getLongitude());

			$preSQL->execute();

		}

		return $endereco;

	}

	public function buscarPorId($idEndereco) {

		if (empty($idEndereco)) {
			return null;
		}

		$strSQL = "SELECT * FROM endereco ";
		$strSQL .= "WHERE id = :id ";

		$preSQL = ConexaoPDO::getInstance()->prepare($strSQL);
		$preSQL->bindValue(":id", $idEndereco);
		$preSQL->execute();

		$result = $preSQL->fetchAll(PDO::FETCH_CLASS, "Fluxa\Entity\Endereco");

		if (count($result) > 0) {
			return $result[0];
		}

		return null;

	}

	public function remover(Endereco $endereco) {

		$strSQL = "DELETE FROM endereco ";
		$strSQL .= "WHERE id = :id";

		$preSQL = ConexaoPDO::getInstance()->prepare($strSQL);
		$preSQL->bindValue(":id", $endereco->getId());
		return $preSQL->execute();

	}

}

?>
