<?php
namespace Fluxa\Business;

use Facebook\Facebook as Facebook;
use Google_Client as Google_Client;
use Fluxa\Business\UsuarioBusiness;

class LoginBusiness {

	private $businessUsuario;

	function __construct() {
		$this->usuarioBusiness = new UsuarioBusiness();
	}

	public function getUrlLoginFacebook() {

		$fb = $this->getFacebookObj();

		$helper = $fb->getRedirectLoginHelper();

		$permissions = array("email");

		$urlLogin = URI_SISTEMA . "login/facebook?sco=1";
		$loginUrl = $helper->getLoginUrl($urlLogin, $permissions);
                

		return $loginUrl;

	}

	public function getUrlLoginGoogle() {

		$client = $this->getGoogleObj();
		return $client->createAuthUrl();

	}

	public function getFacebookObj() {

		$fb = new Facebook([
			'app_id' => K_FACEBOOK_APP_ID,
			'app_secret' => K_FACEBOK_APP_SECRET ,
			'default_graph_version' => 'v2.12',
		]);

		return $fb;

	}

	public function getGoogleObj() {

		$client = new Google_Client();
		$client->setAuthConfig('client_google.json');
		$client->addScope("email");
		$client->addScope("profile");
		$urlLogin = URI_SISTEMA . "login/google";
		$client->setRedirectUri($urlLogin);

		return $client;

	}

}