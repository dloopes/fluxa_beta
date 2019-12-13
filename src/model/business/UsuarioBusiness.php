<?php
namespace Fluxa\Business;

use Fluxa\Exception\BusinessException;
use Fluxa\Entity\Usuario;
use Fluxa\Entity\Recurso;
use Fluxa\Persistence\UsuarioDAO;
use Fluxa\Business\RecursoBusiness;

class UsuarioBusiness {

	private $daoUsuario;
	private $recursoBusiness;

	function __construct() {
		$this->daoUsuario = new UsuarioDAO();
		$this->recursoBusiness = new RecursoBusiness();
	}
        
            //Quando a api estiver usando o sistema, vamos salvar o usuário aqui para futuras interações.
        public function setUserApi($id){
            $GLOBALS["id_usuario_api"] = $id;
        }
        
        public function getUserApi(){
            return $GLOBALS["id_usuario_api"];
        }

        public static function getToken($id){ //Token para ser usado na api do usuário.
            return md5(KEY_PASS."|".$id);
        }
        
        public static function getAuthorizationKey($id){
            return $id."-".self::getToken($id);
        }
        
        public static function getAuthorizationApi(){
              // print_r( $_SESSION ); die(" ");
		/* if ( ! is_null( $_SESSION['usuario_logado']) ){                    
                    $usuario = $_SESSION['usuario_logado'];                    
                    return self::getAuthorizationKey($usuario->id);
                }
                */
                return self::getAuthorizationKey( $_SESSION["id"] );
        }

	public function salvar(Usuario $usuario) {

		if (empty($usuario) || empty($usuario->getEmail()) || empty($usuario->getNome())) {
			throw new BusinessException("Email e nome não podem ser nulos");
			return null;
		}

		if (empty($usuario->getId()) && $usuario->getPerfil() == Usuario::USUARIO_DEFAULT) {

			$usuarioExistente = $this->buscaUsuarioPorEmail($usuario->getEmail());

			if (!empty($usuarioExistente)) {

				if($usuario->isEmailConfirmado()){
					throw new BusinessException("Email já cadastrado");
				}else{
					$usuario->setId($usuarioExistente->getId());
				}
				
			}
		}

		return $this->daoUsuario->salvar($usuario);

	}

	public function autenticaUsuario($email, $senha) {

		$usuario = $this->buscaUsuarioPorEmail($email);

		if (empty($usuario)) {
			throw new BusinessException("Email não cadastrado");
		}

		if ($usuario->getDelete()) {
			throw new BusinessException("Usuário está inativo");
		}

		if (!$usuario->isEmailConfirmado()) {
			throw new BusinessException("Cadastro não foi confirmado, verifique seu email.");
		}

		if (md5($senha) != $usuario->getSenha()) {
			throw new BusinessException("Senha incorreta");
		}

		$_SESSION['usuario_logado'] = $usuario;

		$_SESSION['tipo_login'] = Usuario::USUARIO_DEFAULT;
		$_SESSION['token'] = "123456";
		$_SESSION['nome'] = $usuario->getNome();
		$_SESSION['id'] = $usuario->getId();
		$_SESSION['email'] = $usuario->getEmail();
		$_SESSION['image'] = $usuario->getUrlImagem();

		$_SESSION['qtde_total_usuarios'] = $this->getQtdeUsuariosCadastrados();
		$_SESSION['qtde_total_potencialidades'] = $this->recursoBusiness->getQtdeTotalRecursos(Recurso::TIPO_POTENCIALIDADE);
		$_SESSION['qtde_total_possibilidades'] = $this->recursoBusiness->getQtdeTotalRecursos(Recurso::TIPO_POSSIBILIDADE);

		return true;

	}
        
    
	public function verificaUsuarioLogado() {

		if (isset($_SESSION['usuario_logado']) && !empty($_SESSION['usuario_logado'])) {
			return true;
		}

		return false;

	}

	public function buscaTodosUsuarios() {

		$usuarios = $this->daoUsuario->buscarUsuarios(null);

		return $usuarios;

	}

	public function buscarUsuariosOrdenadoPorQtdeRecurso() {

		$usuarios = $this->daoUsuario->buscarUsuariosOrdenadoPorQtdeRecurso();

		return $usuarios;

	}
	

	public function getQtdeUsuariosCadastrados() {

		//Melhorar implementando acesso ao banco
		return count($this->buscaTodosUsuarios());

	}

	public function buscaUsuarioPorId($id) {

		return $this->daoUsuario->buscarUsuarioPorId($id);

	}

	public function buscaUsuarioPorEmail($email) {

		return $this->daoUsuario->buscaUsuarioPorEmail($email);

	}

	public function buscaUsuarioPorIdRedeSocial($idRedeSocial, $perfil) {

		return $this->daoUsuario->buscarUsuarioPorIdRedeSocial($idRedeSocial, $perfil);

	}

	public function buscarUsuarioPelaChaveCadastro($chaveCadastro) {

		if (empty($chaveCadastro)) {
			return null;
		}

		return $this->daoUsuario->buscarUsuarioPelaChaveCadastro($chaveCadastro);

	}

	public function buscarUsuarioPelaChaveRecuperarSenha($chaveRecuperarSenha) {

		if (empty($chaveRecuperarSenha)) {
			return null;
		}

		return $this->daoUsuario->buscarUsuarioPelaChaveRecuperarSenha($chaveRecuperarSenha);

	}

}