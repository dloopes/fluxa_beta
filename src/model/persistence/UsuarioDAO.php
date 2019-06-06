<?php
namespace Fluxa\Persistence;

use Fluxa\Entity\Usuario;
use \Slim\PDO\Database as PDO;

class UsuarioDAO {

	public function __construct() {

	}

	public function salvar(Usuario $usuario) {

		if (empty($usuario->getId())) {

			$strSQL = "INSERT INTO usuario(id_rede_social, nome, email, url_imagem, senha, perfil, data_cadastro, data_ultimo_acesso, chave_cadastro, email_confirmado) ";
			$strSQL .= "VALUES (:id_rede_social, :nome, :email, :url_imagem, :senha, :perfil, NOW(), NOW(), :chave_cadastro, :email_confirmado)";

			$preSQL = ConexaoPDO::getInstance()->prepare($strSQL);

			$preSQL->bindValue(":id_rede_social", $usuario->getIdRedeSocial());
			$preSQL->bindValue(":nome", $usuario->getNome());
			$preSQL->bindValue(":email", $usuario->getEmail());
			$preSQL->bindValue(":url_imagem", $usuario->getUrlImagem());
			$preSQL->bindValue(":senha", $usuario->getSenha());
			$preSQL->bindValue(":perfil", $usuario->getPerfil());
			$preSQL->bindValue(":chave_cadastro", $usuario->getChaveCadastro());
			$preSQL->bindValue(":email_confirmado", $usuario->isEmailConfirmado());

			$preSQL->execute();

			$usuario->setId(ConexaoPDO::getInstance()->lastInsertId());

		} else {

			$strSQL = "UPDATE usuario SET ";
			$strSQL .= "id_rede_social = :id_rede_social, ";
			$strSQL .= "nome = :nome, ";
			$strSQL .= "email = :email, ";
			$strSQL .= "url_imagem = :url_imagem, ";
			$strSQL .= "senha = :senha, ";
			$strSQL .= "perfil = :perfil, ";
			$strSQL .= "chave_cadastro = :chave_cadastro, ";
			$strSQL .= "email_confirmado = :email_confirmado, ";
			$strSQL .= "recuperar_senha = :recuperar_senha, ";
			$strSQL .= "chave_recuperar_senha = :chave_recuperar_senha ";
			$strSQL .= "WHERE id = :id";

			$preSQL = ConexaoPDO::getInstance()->prepare($strSQL);

			$preSQL->bindValue(":id_rede_social", $usuario->getIdRedeSocial());
			$preSQL->bindValue(":nome", $usuario->getNome());
			$preSQL->bindValue(":email", $usuario->getEmail());
			$preSQL->bindValue(":url_imagem", $usuario->getUrlImagem());
			$preSQL->bindValue(":senha", $usuario->getSenha());
			$preSQL->bindValue(":perfil", $usuario->getPerfil());
			$preSQL->bindValue(":chave_cadastro", $usuario->getChaveCadastro());
			$preSQL->bindValue(":email_confirmado", $usuario->isEmailConfirmado());
			$preSQL->bindValue(":recuperar_senha", $usuario->isRecuperarSenha());
			$preSQL->bindValue(":chave_recuperar_senha", $usuario->getChaveRecuperarSenha());
			$preSQL->bindValue(":id", $usuario->getId());

			$preSQL->execute();

		}

		return $usuario;

	}

	public function buscarUsuarios($idCliente = null) {

		$strSQL = "SELECT * FROM usuario";

		$preSQL = ConexaoPDO::getInstance()->prepare($strSQL);
		$preSQL->execute();

		return $preSQL->fetchAll(PDO::FETCH_CLASS, "Fluxa\Entity\Usuario");

	}

	public function buscarUsuariosOrdenadoPorQtdeRecurso() {

		$strSQL = "SELECT DISTINCT u.*, (SELECT COUNT(*) FROM recurso r WHERE r.id_usuario = u.id) as qtde_recursos ";
		$strSQL .= "FROM usuario u ";
		$strSQL .= "ORDER BY qtde_recursos DESC ";

		$preSQL = ConexaoPDO::getInstance()->prepare($strSQL);
		$preSQL->execute();

		return $preSQL->fetchAll(PDO::FETCH_CLASS, "Fluxa\Entity\Usuario");

	}

	public function buscarUsuarioPorId($id) {

		if (empty($id)) {
			return null;
		}

		$strSQL = "SELECT * FROM usuario ";
		$strSQL .= "WHERE id = :id";

		$preSQL = ConexaoPDO::getInstance()->prepare($strSQL);
		$preSQL->bindValue(":id", $id);
		$preSQL->execute();

		$result = $preSQL->fetchAll(PDO::FETCH_CLASS, "Fluxa\Entity\Usuario");

		if (count($result) > 0) {
			return $result[0];
		}

		return null;

	}

	public function buscarUsuarioPorIdRedeSocial($idRedeSocial, $perfil) {

		if (empty($idRedeSocial) || empty($perfil)) {
			return null;
		}

		$strSQL = "SELECT * FROM usuario ";
		$strSQL .= "WHERE id_rede_social = :id_rede_social ";
		$strSQL .= "AND perfil = :perfil ";

		$preSQL = ConexaoPDO::getInstance()->prepare($strSQL);
		$preSQL->bindValue(":id_rede_social", $idRedeSocial);
		$preSQL->bindValue(":perfil", $perfil);
		$preSQL->execute();

		$result = $preSQL->fetchAll(PDO::FETCH_CLASS, "Fluxa\Entity\Usuario");

		if (count($result) > 0) {
			return $result[0];
		}

		return null;

	}

	public function buscaUsuarioPorEmail($email) {

		if (empty($email)) {
			return null;
		}

		$strSQL = "SELECT * FROM usuario ";
		$strSQL .= "WHERE email = :email";

		$preSQL = ConexaoPDO::getInstance()->prepare($strSQL);
		$preSQL->bindValue(":email", $email);
		$preSQL->execute();

		$result = $preSQL->fetchAll(PDO::FETCH_CLASS, "Fluxa\Entity\Usuario");

		if (count($result) > 0) {
			return $result[0];
		}

		return null;

	}

	public function buscarUsuarioPelaChaveCadastro($chaveCadastro) {

		if (empty($chaveCadastro)) {
			return null;
		}

		$strSQL = "SELECT * FROM usuario ";
		$strSQL .= "WHERE chave_cadastro = :chave_cadastro";

		$preSQL = ConexaoPDO::getInstance()->prepare($strSQL);
		$preSQL->bindValue(":chave_cadastro", $chaveCadastro);
		$preSQL->execute();

		$result = $preSQL->fetchAll(PDO::FETCH_CLASS, "Fluxa\Entity\Usuario");

		if (count($result) > 0) {
			return $result[0];
		}

		return null;
	}

	public function buscarUsuarioPelaChaveRecuperarSenha($chaveRecuperarSenha) {

		if (empty($chaveRecuperarSenha)) {
			return null;
		}

		$strSQL = "SELECT * FROM usuario ";
		$strSQL .= "WHERE chave_recuperar_senha = :chave_recuperar_senha";

		$preSQL = ConexaoPDO::getInstance()->prepare($strSQL);
		$preSQL->bindValue(":chave_recuperar_senha", $chaveRecuperarSenha);
		$preSQL->execute();

		$result = $preSQL->fetchAll(PDO::FETCH_CLASS, "Fluxa\Entity\Usuario");

		if (count($result) > 0) {
			return $result[0];
		}

		return null;
	}

}

?>
