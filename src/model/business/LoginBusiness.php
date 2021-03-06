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

		$urlLogin = URI_SISTEMA . "login/facebook";
		$loginUrl = $helper->getLoginUrl($urlLogin, $permissions);

		return $loginUrl;

	}

	public function getUrlLoginGoogle() {

		$client = $this->getGoogleObj();
		return $client->createAuthUrl();

	}

	public function getFacebookObj() {

		$fb = new Facebook([
			'app_id' => '2018457761813920',
			'app_secret' => 'f3d9078b26055c4055fb5916dbd6c834',
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