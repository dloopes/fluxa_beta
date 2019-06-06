<?php
namespace Fluxa\Controller;

use \Fluxa\Business\UsuarioBusiness;

//Controller gerado para responder a itens simples e publicos
class SecurityController {

	public function verificaUsuarioLogado($request, $response, $next) {

		$usuarioBusiness = new UsuarioBusiness();

		// Pega rota atual
		$path = $request->getUri()->getPath();

		$rotaPublica = $this->verificaRotaPublica($path);

		if ($rotaPublica) {
			return $next($request, $response);
		}

		// Verifica token
		$usuarioLogado = $usuarioBusiness->verificaUsuarioLogado();

		if ($usuarioLogado) {
			return $next($request, $response);
		} else {
			return $response->withStatus(302)->withHeader('Location', URI_SISTEMA . 'login');
		}

	}

	private function verificaRotaPublica($rota) {

		$itensRota = explode("/", $rota); 

		$primeiroItemRota = $itensRota	[0];

		/*$ultimoCaractere = substr($rota, strlen($rota) - 1, 1);

		if ($ultimoCaractere == "/") {
			$rota = substr($rota, 0, -1);
		}*/

		// Lista de rotas publicas
		$rotasPublicas = array(
			"",
			"login",
			"logout",
			"cadastro",
			"recuperar_senha",
			"redefinir_senha"
		);

		// Libera o acesso a rotas publicas
		if (!in_array($primeiroItemRota, $rotasPublicas)) {
			return false;
		}

		return true;

	}

}