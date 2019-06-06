<?php
namespace Fluxa\Controller;

use Google_Service_Oauth2 as Google_Service_Oauth2;
use Slim\Http\Response as Response;
use Fluxa\Business\LoginBusiness;
use Fluxa\Business\UsuarioBusiness;
use Fluxa\Business\RecursoBusiness;
use Fluxa\Exception\BusinessException;
use Fluxa\Exception\ControlerException;
use Fluxa\Entity\Usuario;
use Fluxa\Entity\Recurso;

class LoginController {

	private $view;

	private $loginBusiness;
	private $recursoBusiness;

	private $message;

	public function __construct($view) {
		$this->view = $view;
		$this->loginBusiness = new LoginBusiness();
		$this->usuarioBusiness = new UsuarioBusiness();
		$this->recursoBusiness = new RecursoBusiness();
	}

	public function getLogin($request, $response, $args) {

		if ($this->usuarioBusiness->verificaUsuarioLogado()) {
			return $response->withStatus(302)->withHeader('Location', URI_SISTEMA . 'painel');
		}

		$urlFacebook = $this->loginBusiness->getUrlLoginFacebook();
		$urlGoogle = $this->loginBusiness->getUrlLoginGoogle();

		return $this->view->render($response, "Login.php", [
			"urlFacebook" => $urlFacebook,
			"urlGoogle" => $urlGoogle,
		]);

	}

	public function getLogout($request, $response, $args) {

		unset($_SESSION['tipo_login']);
		unset($_SESSION['token']);
		unset($_SESSION['nome']);
		unset($_SESSION['id']);
		unset($_SESSION['email']);
		unset($_SESSION['image']);
		unset($_SESSION['usuario_logado']);

		return $response->withStatus(302)->withHeader('Location', URI_SISTEMA . 'login');

	}

	public function login($request, $response, $args) {

		try {

			$dadosRequest = $request->getParsedBody();

			$email = $dadosRequest['email'];
			$senha = $dadosRequest['senha'];

			if (empty($email)) {
				throw new ControlerException("Email é obrigatório");
			}

			if (empty($senha)) {
				throw new ControlerException("Senha é obrigatório");
			}

			$usuarioValido = $this->usuarioBusiness->autenticaUsuario($email, $senha);

			if($usuarioValido){
				return $response->withStatus(302)->withHeader('Location', URI_SISTEMA . 'painel');
			}else{
				$_SESSION['msg_alerta'] = "Dados inválidos!";
				return $response->withStatus(302)->withHeader('Location', URI_SISTEMA . 'login');
			}

		} catch (ControlerException $ce) {
			$_SESSION['msg_alerta'] = $ce->getMessage();
			return $response->withStatus(302)->withHeader('Location', URI_SISTEMA . 'login');
		} catch (BusinessException $be) {
			$_SESSION['msg_alerta'] = $be->getMessage();
			return $response->withStatus(302)->withHeader('Location', URI_SISTEMA . 'login');
		}

	}

	public function loginFacebook($request, $response, $args) {

		$fb = $this->loginBusiness->getFacebookObj();

		$helper = $fb->getRedirectLoginHelper();

		try {

			$accessToken = $helper->getAccessToken();

			if (isset($accessToken)) {

				$fb->setDefaultAccessToken($accessToken);

				try {

					$responseFace = $fb->get('/me?fields=email,name');
					$userNode = $responseFace->getGraphUser();

				} catch (Facebook\Exceptions\FacebookResponseException $e) {
					// When Graph returns an error
					echo 'Graph returned an error: ' . $e->getMessage();
					exit;
				} catch (Facebook\Exceptions\FacebookSDKException $e) {
					// When validation fails or other local issues
					echo 'Facebook SDK returned an error: ' . $e->getMessage();
					exit;
				}

				if(empty($userNode->getProperty('email'))){
					$_SESSION['msg_alerta'] = "Não foi possível recuperar o e-mail dessa conta. Por favor, verifique as configurações no facebook.";
					return $response->withStatus(302)->withHeader('Location', URI_SISTEMA . 'login');
					//var_dump($userNode);
					//exit;
				}
				
				//Verifica se o usuario ja foi cadastrado
				//$usuario = $this->usuarioBusiness->buscaUsuarioPorIdRedeSocial($userNode->getId(), Usuario::USUARIO_FACEBOOK);
				$usuario = $this->usuarioBusiness->buscaUsuarioPorEmail($userNode->getProperty('email'));

				if (empty($usuario)) {
					$usuario = new Usuario();
				}

				$usuario->setPerfil(Usuario::USUARIO_FACEBOOK);
				$usuario->setIdRedeSocial($userNode->getId());
				$usuario->setNome($userNode->getName());
				$usuario->setSenha(null);
				$usuario->setEmail($userNode->getProperty('email'));
				$usuario->setUrlImagem('https://graph.facebook.com/' . $userNode->getId() . '/picture?width=200');
				$usuario->setEmailConfirmado(1);

				$usuario = $this->usuarioBusiness->salvar($usuario);

				$_SESSION['usuario_logado'] = $usuario;

				$_SESSION['tipo_login'] = "facebook";
				$_SESSION['token'] = $token;
				$_SESSION['nome'] = $userNode->getName();
				$_SESSION['id'] = $usuario->getId();
				$_SESSION['email'] = $userNode->getProperty('email');
				$_SESSION['image'] = 'https://graph.facebook.com/' . $userNode->getId() . '/picture?width=400';

				$_SESSION['qtde_total_usuarios'] = $this->usuarioBusiness->getQtdeUsuariosCadastrados();

				$_SESSION['qtde_total_potencialidades'] = $this->recursoBusiness->getQtdeTotalRecursos(Recurso::TIPO_POTENCIALIDADE);
				$_SESSION['qtde_total_possibilidades'] = $this->recursoBusiness->getQtdeTotalRecursos(Recurso::TIPO_POSSIBILIDADE);

				$newResponse = new Response();

				return $newResponse->withStatus(302)->withHeader('Location', URI_SISTEMA . 'painel');

			}

		} catch (Facebook\Exceptions\FacebookResponseException $e) {
			echo 'Graph returned an error: ' . $e->getMessage();
			exit;
		} catch (Facebook\Exceptions\FacebookSDKException $e) {
			echo 'Facebook SDK returned an error: ' . $e->getMessage();
			exit;
		} catch (ControlerException $ce) {
			$_SESSION['msg_alerta'] = $ce->getMessage();
			return $response->withStatus(302)->withHeader('Location', URI_SISTEMA . 'login');
		}

	}

	public function loginGoogle($request, $response, $args) {

		$client = $this->loginBusiness->getGoogleObj();

		$client->authenticate($_GET['code']);

		$token = $client->getAccessToken();

		$payload = $client->verifyIdToken($token["id_token"]);

		if (!$payload) {
			// Falha na verificacao login
		}

		$service = new Google_Service_Oauth2($client);

		$user = $service->userinfo->get();

		//Verifica se o usuario ja foi cadastrado
		//$usuario = $this->usuarioBusiness->buscaUsuarioPorIdRedeSocial($user->id, Usuario::USUARIO_GOOGLE);
		$usuario = $this->usuarioBusiness->buscaUsuarioPorEmail($user->email);

		if (empty($usuario)) {
			$usuario = new Usuario();
		}

		$usuario->setPerfil(Usuario::USUARIO_GOOGLE);
		$usuario->setIdRedeSocial($user->id);
		$usuario->setNome($user->name);
		$usuario->setSenha(null);
		$usuario->setEmail($user->email);
		$usuario->setUrlImagem($user->picture);
		$usuario->setEmailConfirmado(1);

		$usuario = $this->usuarioBusiness->salvar($usuario);

		$_SESSION['usuario_logado'] = $usuario;

		$_SESSION['tipo_login'] = "google";
		$_SESSION['token'] = $token;
		$_SESSION['nome'] = $user->name;
		$_SESSION['id'] = $usuario->getId();
		$_SESSION['email'] = $user->email;
		$_SESSION['image'] = $user->picture;

		$_SESSION['qtde_total_usuarios'] = $this->usuarioBusiness->getQtdeUsuariosCadastrados();
		$_SESSION['qtde_total_potencialidades'] = $this->recursoBusiness->getQtdeTotalRecursos(Recurso::TIPO_POTENCIALIDADE);
		$_SESSION['qtde_total_possibilidades'] = $this->recursoBusiness->getQtdeTotalRecursos(Recurso::TIPO_POSSIBILIDADE);

		return $response->withStatus(302)->withHeader('Location', URI_SISTEMA . 'painel');

	}

}