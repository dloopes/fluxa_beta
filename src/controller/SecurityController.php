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
                
                $rotaApi= $this->verificaRotaApi($path, $request);
                
                if ($rotaApi) {
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
        
        
	private function verificaRotaApi($rota, $request) {

		$itensRota = explode("/", $rota); 

		$primeiroItemRota = $itensRota	[0];

		/*$ultimoCaractere = substr($rota, strlen($rota) - 1, 1);

		if ($ultimoCaractere == "/") {
			$rota = substr($rota, 0, -1);
		}*/

		// Lista de rotas publicas
		$rotas = array(
			"api"
		);
                
                
                
               $authorization = $request->getHeader('Authorization');

		// Libera o acesso a rota de api
		if (in_array($primeiroItemRota, $rotas)) {
                    
                    if ( !is_null($authorization) && count($authorization) > 0 ){
                        
                        $authorization = $authorization[0];
                        
                         $exp = explode("-", $authorization); // id do usuario-chave de testes.
                     
                         $id = $exp[0];
                         $chave = $exp[1];
                         
                         if ( $chave == UsuarioBusiness::getToken($id)){
                             $GLOBALS["id_usuario_api"] = $id;
                             $GLOBALS["chave_usuario_api"] = $chave;
                             return true; //Tudo certo..
                         } 
                    
                    }
                    
		}

		return false;

	}

}