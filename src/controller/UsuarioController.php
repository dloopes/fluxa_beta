<?php
namespace Fluxa\Controller;

use Fluxa\Business\EmailBusiness as EmailBusiness;
use Fluxa\Business\UsuarioBusiness;
use Fluxa\Business\RecursoBusiness;
use Fluxa\Business\FluxoBusiness;
use Fluxa\Exception\BusinessException;
use Fluxa\Exception\ControlerException;
use Fluxa\Entity\Usuario;
use Fluxa\Entity\Recurso;
use Fluxa\Entity\Fluxo;

class UsuarioController {

	private $view;

	private $message;

	private $usuarioAux;

	private $recursoBusiness;
	private $fluxoBusiness;

	public function __construct($view) {
		$this->view = $view;
		$this->usuarioAux = new Usuario();

		$this->recursoBusiness = new RecursoBusiness();
		$this->fluxoBusiness = new FluxoBusiness();
	}

	public function novoUsuario($request, $response, $args) {

		$emailBusiness = new EmailBusiness();

		try {

			$dadosRequest = $request->getParsedBody();

			$nome = $dadosRequest['nome'];
			$email = $dadosRequest['email'];
			$senha = $dadosRequest['senha'];
			$confirmaSenha = $dadosRequest['confirma_senha'];

			//Retorna dados p view em caso de erro de validacao
			$this->usuarioAux->setNome($nome);
			$this->usuarioAux->setEmail($email);

			if (empty($nome)) {
				throw new ControlerException("Nome é obrigatório");
			}

			if (empty($email)) {
				throw new ControlerException("Email é obrigatório");
			}

			if (empty($senha)) {
				throw new ControlerException("Senha é obrigatório");
			}

			if ($senha != $confirmaSenha) {
				throw new ControlerException("Confirmar senha não confere, tente novamente");
			}

			$usuario = new Usuario();
			$usuario->setNome($nome);
			$usuario->setEmail($email);
			$usuario->setSenha($senha);
			$usuario->setPerfil(Usuario::USUARIO_DEFAULT);

			$usuarioBusiness = new UsuarioBusiness();

			//Salva usuario obtendo id
			$usuario = $usuarioBusiness->salvar($usuario);

			$usuario->gerarChaveCadastro();
			$usuario->setEmailConfirmado(0);

			//Atualiza usuario com os dados de confirmacao do cadastro
			$usuario = $usuarioBusiness->salvar($usuario);		

			//Enviar email de confirmação
			$emailEnviado = $emailBusiness->enviarEmailCadastro($usuario->getChaveCadastro(), $usuario->getEmail());

			if (!$emailEnviado) {

				return $this->view->render($response, "CadastroUsuario.php", [
					"msg_danger" => "Problemas ao enviar email. Por favor, tente mais tarde.",
					"usuario" => $usuario,
				]);

			} else {

				return $this->view->render($response, "CadastroUsuario.php", [
					"msg_success" => "Um link de confirmação foi enviado para " . $usuario->getEmail(),
					"usuario" => new Usuario(),
				]);
			}

		} catch (ControlerException $ce) {
			$this->message = $ce->getMessage();
			return $this->getCadastro($request, $response, $args);
		} catch (BusinessException $be) {
			$this->message = $be->getMessage();
			return $this->getCadastro($request, $response, $args);
		}

	}

	public function getUsuarios($request, $response, $args) {

		$numPag = $request->getAttribute('pag');
              

		//$response = $response->withHeader('Content-type', 'html; charset=utf-8');

		$usuarioBusiness = new UsuarioBusiness();

		$usuarios = array();

		if (empty($chavePesq)) {
			$usuarios = $usuarioBusiness->buscarUsuariosOrdenadoPorQtdeRecurso();
		} else {
			$usuarios = $usuarioBusiness->buscaUsuarioPorNome($chavePesq);
		}
                //  die("testes? ");

		return $this->view->render($response, "TemplatePainel.php", [
			"pagina" =>"ListaUsuario.php",
			"listaUsuarios" => $usuarios, 
			"numPag" => $numPag
		]);

	}

	public function getUsuario($request, $response, $args) {

		$idUsuario = $request->getAttribute('id_usuario');
		$tab = $request->getAttribute('tab');
               

		if (empty($idUsuario)) {
			throw new ControlerException("Id inválido");
		}

		if (empty($tab)) {
			$tab = "fluxos";
		}


		$usuarioBusiness = new UsuarioBusiness();

		$usuario = $usuarioBusiness->buscaUsuarioPorId($idUsuario);

		if (empty($usuario)) {
			throw new ControlerException("Usuário não encontrado");
		}

		$dados = array();

		$numPag = $request->getAttribute('pag');

		if(empty($numPag)){
			$numPag = 1;
		}
		
		$listaFluxos = $this->fluxoBusiness->buscarPorUsuario($idUsuario);
		$listaPotencialidades = $this->recursoBusiness->buscarPotencialidadesPorUsuario($idUsuario);
		$listaPossibilidades = $this->recursoBusiness->buscarPossibilidadesPorUsuario($idUsuario);
		
		$dados['u1_total_ofertas'] = $this->recursoBusiness->getQtdeTotalRecursosPorUsuario($usuario->getId(), Recurso::TIPO_POTENCIALIDADE);
		$dados['u1_total_necessidades'] = $this->recursoBusiness->getQtdeTotalRecursosPorUsuario($usuario->getId(), Recurso::TIPO_POSSIBILIDADE);
		$dados['u1_total_fluxos'] = $this->fluxoBusiness->getTotalQtdePorUsuario($usuario->getId());

		return $this->view->render($response, "TemplatePainel.php", [
			"pagina" =>"PerfilUsuario.php",
			"usuario" => $usuario,
			"listaFluxos" => $listaFluxos,
			"listaPotencialidades" => $listaPotencialidades,
			"listaPossibilidades" => $listaPossibilidades,
			"dados" => $dados,
			"tab" => $tab,
			"numPag" => $numPag
		]);

	}

	public static function getUsuarioPorId($request, $response, $args) {

		$response = $response->withHeader('Content-type', 'application/json; charset=utf-8');

		$usuarioBusiness = new UsuarioBusiness();

		if (!$usuarioBusiness->usuarioValido($request->getHeaderLine('Usuario'), $request->getHeaderLine('Senha'))) {
			$response = $response->withStatus(401);
			$err = '{"error": {"text": "Erro de Autenticação!"}}';
			return $response->write($err);
		}

		//Processa
		$id = $request->getAttribute('id');
		$usuario = $usuarioBusiness->buscaUsuarioPorId($id);

		if (sizeof($usuario) == 0) {
			$response = $response->withStatus(204);
			$msg = '{"msg": {"text": "Usuário há resultado para esse id!"}}';
			return $response->write($msg);
		}

		//Responde
		return $response->write(json_encode($usuario));

	}

	public function getLogin($request, $response, $args) {

		return $this->view->render($response, "Login.php");

	}

	public function getCadastro($request, $response, $args) {

		if (empty($this->usuarioAux)) {
			$this->usuarioAux = new Usuario();
		}

		return $this->view->render($response, "CadastroUsuario.php", [
			"msg" => $this->message,
			"usuario" => $this->usuarioAux,
		]);

	}

	public function confirmaEmail($request, $response, $args) {

		$usuarioBusiness = new UsuarioBusiness();

		$chave_cadastro = $request->getAttribute('key');

		if (empty($chave_cadastro)) {
			return $response->withStatus(302)->withHeader('Location', URI_SISTEMA . 'login');
		}

		$usuario = $usuarioBusiness->buscarUsuarioPelaChaveCadastro($chave_cadastro);

		if (empty($usuario)) {
			return $response->withStatus(302)->withHeader('Location', URI_SISTEMA . 'login');
		}

		if ($usuario->isEmailConfirmado()) {
			return $response->withStatus(302)->withHeader('Location', URI_SISTEMA . 'login');
		}

		$usuario->setEmailConfirmado(1);
		$usuario = $usuarioBusiness->salvar($usuario);

		$_SESSION['usuario_logado'] = $usuario;

		$_SESSION['tipo_login'] = "default";
		$_SESSION['token'] = "123456";
		$_SESSION['nome'] = $usuario->getNome();
		$_SESSION['id'] = $usuario->getId();
		$_SESSION['email'] = $usuario->getEmail();
		$_SESSION['image'] = 'https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg';

		return $response->withStatus(302)->withHeader('Location', URI_SISTEMA . 'painel');

	}

	public function getRecuperarSenha($request, $response, $args) {

		if (empty($this->usuarioAux)) {
			$this->usuarioAux = new Usuario();
		}

		return $this->view->render($response, "RecuperarSenha.php", [
			"msg" => $this->message,
			"usuario" => $this->usuarioAux,
		]);

	}

	public function postRecuperarSenha($request, $response, $args) {

		$usuarioBusiness = new UsuarioBusiness();

		$emailBusiness = new EmailBusiness();

		try {

			$dadosRequest = $request->getParsedBody();

			$email = $dadosRequest['email'];

			//Retorna dados p view em caso de erro de validacao
			$this->usuarioAux->setEmail($email);

			if (empty($email)) {
				throw new ControlerException("Email é obrigatório");
			}

			$usuario = $usuarioBusiness->buscaUsuarioPorEmail($email);

			if (empty($usuario)) {
				throw new ControlerException("Email não encontrado");
			}

			//Somente usuarios default poderão recuperar
			if ($usuario->getPerfil() != Usuario::USUARIO_DEFAULT) {
				throw new ControlerException("Faça o login na rede social vinculada a esse email");
			}

			$usuario->gerarChaveRecuperarSenha();
			$usuario->setRecuperarSenha(1);

			//Salva usuario para recuperacao de senha
			$usuario = $usuarioBusiness->salvar($usuario);

			//Enviar email de confirmação
			$emailEnviado = $emailBusiness->enviarEmailRecuperarSenha($usuario->getChaveRecuperarSenha(), $usuario->getEmail());

			if (!$emailEnviado) {
				return $this->view->render($response, "RecuperarSenha.php", [
					"msg" => "Problemas ao enviar email. Por favor, tente mais tarde.",
					"usuario" => $this->usuarioAux,
				]);
			} else {
				return $this->view->render($response, "RecuperarSenha.php", [
					"msg" => "Um link de recuperação de senha foi enviado para " . $usuario->getEmail(),
					"usuario" => new Usuario(),
				]);
			}

		} catch (ControlerException $ce) {
			$this->message = $ce->getMessage();
			return $this->getRecuperarSenha($request, $response, $args);
		} catch (BusinessException $be) {
			$this->message = $be->getMessage();
			return $this->getRecuperarSenha($request, $response, $args);
		}

	}

	public function confirmaAlterarSenha($request, $response, $args) {

		$usuarioBusiness = new UsuarioBusiness();

		$chave_recuperar_senha = $request->getAttribute('key');

		if (empty($chave_recuperar_senha)) {
			return $response->withStatus(302)->withHeader('Location', URI_SISTEMA . 'login');
		}

		$usuario = $usuarioBusiness->buscarUsuarioPelaChaveRecuperarSenha($chave_recuperar_senha);

		if (empty($usuario)) {
			return $response->withStatus(302)->withHeader('Location', URI_SISTEMA . 'login');
		}

		if (!$usuario->isRecuperarSenha()) {
			return $response->withStatus(302)->withHeader('Location', URI_SISTEMA . 'login');
		}

		$_SESSION['usuario_logado'] = $usuario;

		$_SESSION['tipo_login'] = "default";
		$_SESSION['token'] = "123456";
		$_SESSION['nome'] = $usuario->getNome();
		$_SESSION['id'] = $usuario->getId();
		$_SESSION['email'] = $usuario->getEmail();
		$_SESSION['image'] = 'https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg';

		return $response->withStatus(302)->withHeader('Location', URI_SISTEMA . 'redefinir_senha');

	}

	public function getRedefinirSenha($request, $response, $args) {

		$usuarioBusiness = new UsuarioBusiness();

		if (!$usuarioBusiness->verificaUsuarioLogado()) {
			return $response->withStatus(302)->withHeader('Location', URI_SISTEMA . 'login');
		}

		$usuario = $usuarioBusiness->buscaUsuarioPorId($_SESSION['id']);

		return $this->view->render($response, "RedefinirSenha.php", [
			"msg" => $this->message,
			"usuario" => $usuario,
		]);

	}

	public function postRedefinirSenha($request, $response, $args) {

		$usuarioBusiness = new UsuarioBusiness();

		if (!$usuarioBusiness->verificaUsuarioLogado()) {
			return $response->withStatus(302)->withHeader('Location', URI_SISTEMA . 'login');
		}

		try {

			$dadosRequest = $request->getParsedBody();

			$senha = $dadosRequest['senha'];
			$confirmaSenha = $dadosRequest['confirma_senha'];

			if (empty($senha)) {
				throw new ControlerException("Senha é obrigatório");
			}

			if ($senha != $confirmaSenha) {
				throw new ControlerException("Confirmar senha não confere, tente novamente");
			}

			$usuario = $usuarioBusiness->buscaUsuarioPorId($_SESSION['id']);

			$usuario->setRecuperarSenha(0);
			$usuario->setSenha($senha);

			$usuario = $usuarioBusiness->salvar($usuario);

			return $response->withStatus(302)->withHeader('Location', URI_SISTEMA . 'painel');

		} catch (ControlerException $ce) {
			$this->message = $ce->getMessage();
			return $this->getRedefinirSenha($request, $response, $args);
		} catch (BusinessException $be) {
			$this->message = $be->getMessage();
			return $this->getRedefinirSenha($request, $response, $args);
		}

	}

}
