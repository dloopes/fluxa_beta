<?php
namespace Fluxa\Persistence;

use Fluxa\Entity\Recurso;
use Fluxa\Entity\EnumRecursoStatus;
use \Slim\PDO\Database as PDO;

class RecursoDAO {

	public function __construct() {

	}

	public function salvar(Recurso $recurso) {

		if (empty($recurso->getId())) {

			$strSQL = "INSERT INTO recurso(nome, detalhe, tipo_recurso, id_categoria, id_usuario, status, tipo_fluxo, id_endereco) ";
			$strSQL .= "VALUES (:nome, :detalhe, :tipo_recurso, :id_categoria, :id_usuario, :status, :tipo_fluxo, :id_endereco)";

			$preSQL = ConexaoPDO::getInstance()->prepare($strSQL);

			$preSQL->bindValue(":nome", $recurso->getNome());
			$preSQL->bindValue(":detalhe", $recurso->getDetalhe());
			$preSQL->bindValue(":tipo_recurso", $recurso->getTipo());
			$preSQL->bindValue(":id_categoria", $recurso->getIdCategoria());
			$preSQL->bindValue(":id_usuario", $recurso->getIdUsuario());
			$preSQL->bindValue(":status", $recurso->getStatus());
			$preSQL->bindValue(":tipo_fluxo", $recurso->getTipoFluxo());
			$preSQL->bindValue(":id_endereco", $recurso->getIdEndereco());

			echo($recurso->getIdUsuario());

			$preSQL->execute();

			$recurso->setId(ConexaoPDO::getInstance()->lastInsertId());

		} else {

			$strSQL = "UPDATE recurso SET ";
			$strSQL .= "nome = :nome, ";
			$strSQL .= "detalhe = :detalhe, ";
			$strSQL .= "id_categoria = :id_categoria, ";
			$strSQL .= "status = :status, ";
			$strSQL .= "tipo_fluxo = :tipo_fluxo, ";
			$strSQL .= "id_endereco = :id_endereco ";
			$strSQL .= "WHERE id = :id";

			$preSQL = ConexaoPDO::getInstance()->prepare($strSQL);

			$preSQL->bindValue(":nome", $recurso->getNome());
			$preSQL->bindValue(":detalhe", $recurso->getDetalhe());
			$preSQL->bindValue(":id_categoria", $recurso->getIdCategoria());
			$preSQL->bindValue(":id", $recurso->getId());
			$preSQL->bindValue(":status", $recurso->getStatus());
			$preSQL->bindValue(":tipo_fluxo", $recurso->getTipoFluxo());
			$preSQL->bindValue(":id_endereco", $recurso->getIdEndereco());

			$preSQL->execute();

		}

		return $recurso;

	}

	public function buscarPotencialidades($idUsuario = null, $qtdeMaxRegistros = null, $sohRecursoAtivo = false) {

		$strSQL = "SELECT * FROM recurso ";
		$strSQL .= "WHERE tipo_recurso = :tipo ";

		if(!empty($idUsuario)){
			$strSQL .= "AND id_usuario = :id_usuario ";
		}

		if(!empty($sohRecursoAtivo)){
			$strSQL .= "AND status != :status ";
		}

		$strSQL .= "ORDER BY nome ASC ";

		if(!empty($qtdeMaxRegistros)){
			$strSQL .= "LIMIT :qtde ";	
		}	

		$preSQL = ConexaoPDO::getInstance()->prepare($strSQL);
		
		if(!empty($idUsuario)){
			$preSQL->bindValue(":id_usuario", $idUsuario);
		}

		if(!empty($qtdeMaxRegistros)){
			$preSQL->bindValue(":qtde", $qtdeMaxRegistros);	
		}

		if(!empty($sohRecursoAtivo)){
			$preSQL->bindValue(":status", EnumRecursoStatus::INDISPO);	
		}

		$preSQL->bindValue(":tipo", Recurso::TIPO_POTENCIALIDADE);
		$preSQL->execute();

		return $preSQL->fetchAll(PDO::FETCH_CLASS, "Fluxa\Entity\Recurso");

	}

	public function buscarPossibilidades($idUsuario = null, $qtdeMaxRegistros = null, $sohRecursoAtivo = false) {

		$strSQL = "SELECT * FROM recurso ";
		$strSQL .= "WHERE tipo_recurso = :tipo ";
		
		if(!empty($idUsuario)){
			$strSQL .= "AND id_usuario = :id_usuario ";	
		}

		if(!empty($sohRecursoAtivo)){
			$strSQL .= "AND status != :status ";
		}

		$strSQL .= "ORDER BY nome ASC ";
		
		if(!empty($qtdeMaxRegistros)){
			$strSQL .= "LIMIT :qtde ";	
		}		

		$preSQL = ConexaoPDO::getInstance()->prepare($strSQL);
		
		if(!empty($idUsuario)){
			$preSQL->bindValue(":id_usuario", $idUsuario);
		}

		if(!empty($qtdeMaxRegistros)){
			$preSQL->bindValue(":qtde", $qtdeMaxRegistros);	
		}

		if(!empty($sohRecursoAtivo)){
			$preSQL->bindValue(":status", EnumRecursoStatus::INDISPO);	
		}

		$preSQL->bindValue(":tipo", Recurso::TIPO_POSSIBILIDADE);
		$preSQL->execute();

		return $preSQL->fetchAll(PDO::FETCH_CLASS, "Fluxa\Entity\Recurso");

	}

	public function buscarPorId($idRecurso, $idUsuario = null) {

		if (empty($idRecurso)) {
			return null;
		}

		$strSQL = "SELECT * FROM recurso ";
		$strSQL .= "WHERE id = :id ";

		if(!empty($idUsuario)){
			$strSQL .= "AND id_usuario = :id_usuario ";	
		}

		$preSQL = ConexaoPDO::getInstance()->prepare($strSQL);
		$preSQL->bindValue(":id", $idRecurso);
		
		if(!empty($idUsuario)){
			$preSQL->bindValue(":id_usuario", $idUsuario);
		}

		$preSQL->execute();

		$result = $preSQL->fetchAll(PDO::FETCH_CLASS, "Fluxa\Entity\Recurso");

		if (count($result) > 0) {
			return $result[0];
		}

		return null;

	}

	public function buscarPorNome($nome, $tipoRecurso = null, $sohRecursoAtivo = false) {

		if (empty($nome)) {
			return null;
		}

		$strSQL = "SELECT * FROM recurso ";
		$strSQL .= "WHERE nome LIKE :nome ";

		if(!empty($tipoRecurso)){
			$strSQL .= "AND tipo_recurso = :tipo ";
		}

		if(!empty($sohRecursoAtivo)){
			$strSQL .= "AND status != :status ";
		}

		$preSQL = ConexaoPDO::getInstance()->prepare($strSQL);
		$preSQL->bindValue(":nome", $nome."%");

		if(!empty($tipoRecurso)){
			$preSQL->bindValue(":tipo", $tipoRecurso);
		}

		if(!empty($sohRecursoAtivo)){
			$preSQL->bindValue(":status", EnumRecursoStatus::INDISPO);	
		}

		$preSQL->execute();

		return $preSQL->fetchAll(PDO::FETCH_CLASS, "Fluxa\Entity\Recurso");

	}

	public function getQtdeTotalRecursos($tipoRecurso = null, $sohRecursoAtivo = false) {

		$strSQL = "SELECT COUNT(*) FROM recurso ";

		if(!empty($tipoRecurso)){
			$strSQL .= "WHERE tipo_recurso = :tipo ";
		}

		if(!empty($sohRecursoAtivo)){
			$strSQL .= "AND status != :status ";
		}

		$preSQL = ConexaoPDO::getInstance()->prepare($strSQL);

		if(!empty($tipoRecurso)){
			$preSQL->bindValue(":tipo", $tipoRecurso);
		}

		if(!empty($sohRecursoAtivo)){
			$preSQL->bindValue(":status", EnumRecursoStatus::INDISPO);	
		}

		$preSQL->execute();

		return $preSQL->fetchColumn();

	}

	public function getQtdeTotalRecursosPorUsuario($idUsuario, $tipoRecurso = null, $sohRecursoAtivo = false) {

		$strSQL = "SELECT COUNT(*) FROM recurso ";
		$strSQL .= "WHERE id_usuario = :id_usuario ";

		if(!empty($tipoRecurso)){
			$strSQL .= "AND tipo_recurso = :tipo ";
		}

		if(!empty($sohRecursoAtivo)){
			$strSQL .= "AND status != :status ";
		}

		$preSQL = ConexaoPDO::getInstance()->prepare($strSQL);
		$preSQL->bindValue(":id_usuario", $idUsuario);

		if(!empty($tipoRecurso)){
			$preSQL->bindValue(":tipo", $tipoRecurso);
		}

		if(!empty($sohRecursoAtivo)){
			$preSQL->bindValue(":status", EnumRecursoStatus::INDISPO);	
		}

		$preSQL->execute();

		return $preSQL->fetchColumn(); ;

	}

	public function buscaNomesRecurso($query) {

		$strSQL = "SELECT DISTINCT nome FROM recurso ";
		$strSQL .= "WHERE UPPER(nome) LIKE UPPER(:query)";

		$preSQL = ConexaoPDO::getInstance()->prepare($strSQL);
		$preSQL->bindValue(":query", $query."%");
		$preSQL->execute();

		$resultado = $preSQL->fetchAll();
		
		return $resultado;

	}

	public function remover(Recurso $recurso) {

		$strSQL = "DELETE FROM recurso ";
		$strSQL .= "WHERE id = :id";

		$preSQL = ConexaoPDO::getInstance()->prepare($strSQL);
		$preSQL->bindValue(":id", $recurso->getId());
		return $preSQL->execute();

	}

}

?>
