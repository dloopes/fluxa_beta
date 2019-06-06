<?php
namespace Fluxa\Persistence;

use Fluxa\Entity\RecursoCategoria;
use \Slim\PDO\Database as PDO;

class RecursoCategoriaDAO {

	public function __construct() {

	}

	public function salvar(RecursoCategoria $categoria) {

		if (empty($categoria->getId())) {

			$strSQL = "INSERT INTO recurso_categoria(nome) ";
			$strSQL .= "VALUES (:nome)";

			$preSQL = ConexaoPDO::getInstance()->prepare($strSQL);

			$preSQL->bindValue(":nome", $categoria->getNome());

			$preSQL->execute();

			$categoria->setId(ConexaoPDO::getInstance()->lastInsertId());

		} else {

			$strSQL = "UPDATE recurso_categoria SET ";
			$strSQL .= "nome = :nome, ";
			$strSQL .= "WHERE id = :id";

			$preSQL = ConexaoPDO::getInstance()->prepare($strSQL);

			$preSQL->bindValue(":nome", $categoria->getNome());
			$preSQL->bindValue(":id", $categoria->getId());

			$preSQL->execute();

		}

		return $categoria;

	}

	public function buscar() {

		$strSQL = "SELECT * FROM recurso_categoria";

		$preSQL = ConexaoPDO::getInstance()->prepare($strSQL);
		$preSQL->execute();

		return $preSQL->fetchAll(PDO::FETCH_CLASS, "Fluxa\Entity\RecursoCategoria");

	}

	public function buscarPorId($id) {

		if (empty($id)) {
			return null;
		}

		$strSQL = "SELECT * FROM recurso_categoria ";
		$strSQL .= "WHERE id = :id";

		$preSQL = ConexaoPDO::getInstance()->prepare($strSQL);
		$preSQL->bindValue(":id", $id);
		$preSQL->execute();

		$result = $preSQL->fetchAll(PDO::FETCH_CLASS, "Fluxa\Entity\RecursoCategoria");

		if (count($result) > 0) {
			return $result[0];
		}

		return null;

	}

	public function buscaPorNome($nome) {

		if (empty($nome)) {
			return null;
		}

		$strSQL = "SELECT * FROM recurso_categoria ";
		$strSQL .= "WHERE nome = :nome";

		$preSQL = ConexaoPDO::getInstance()->prepare($strSQL);
		$preSQL->bindValue(":nome", $nome);
		$preSQL->execute();

		$result = $preSQL->fetchAll(PDO::FETCH_CLASS, "Fluxa\Entity\RecursoCategoria");

		if (count($result) > 0) {
			return $result[0];
		}

		return null;

	}

}

?>
