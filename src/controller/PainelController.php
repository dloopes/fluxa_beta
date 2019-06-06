<?php
namespace Fluxa\Controller;

use Fluxa\Business\UsuarioBusiness;
use Fluxa\Business\RecursoBusiness;
use Fluxa\Entity\Recurso;

class PainelController {

	private $view;
	private $usuarioBusiness;
	private $recursoBusiness;

	public function __construct($view) {
		$this->view = $view;
		$this->usuarioBusiness = new UsuarioBusiness();
		$this->recursoBusiness = new RecursoBusiness();
	}

	public function getPainel($request, $response, $args) {

		$nomeRecursoDefault = "Bicicleta";

		if (!$this->usuarioBusiness->verificaUsuarioLogado()) {
			return $response->withStatus(302)->withHeader('Location', URI_SISTEMA . 'login');
		}

		$listaPotencialidades = array();
		$listaPossibilidades = array();

		$listaPotencialidades = $this->recursoBusiness->buscarPorNome($nomeRecursoDefault, Recurso::TIPO_POTENCIALIDADE);
		$listaPossibilidades = $this->recursoBusiness->buscarPorNome($nomeRecursoDefault, Recurso::TIPO_POSSIBILIDADE);
		//$listaPotencialidades = $this->recursoBusiness->buscarPotencialidades(false, 50);
		//$listaPossibilidades = $this->recursoBusiness->buscarPossibilidades(false, 50);

		return $this->view->render($response, "TemplatePainel.php", [
			"pagina" => "PainelControle.php",
			"listaPotencialidades" => $listaPotencialidades,
			"listaPossibilidades" => $listaPossibilidades,
			"nomeFiltro" => "",
			"tipoFiltro" => "",
		]);

	}

	public function postPainel($request, $response, $args) {

		$dadosRequest = $request->getParsedBody();

		$nomeRecurso = $dadosRequest['nome'];
		$tipoRecurso = null;

		if (empty($nomeRecurso)) {
			$this->getPainel($request, $response, $args);
		}

		if(isset($dadosRequest['tipo_recurso']) && !empty($dadosRequest['tipo_recurso'])){
			$tipoRecurso = $dadosRequest['tipo_recurso'];
		}			

		if($tipoRecurso == Recurso::TIPO_POTENCIALIDADE){
			$listaPotencialidades = $this->recursoBusiness->buscarPorNome($nomeRecurso, Recurso::TIPO_POTENCIALIDADE);
			$listaPossibilidades = array();
		}else if($tipoRecurso == Recurso::TIPO_POSSIBILIDADE){
			$listaPossibilidades = $this->recursoBusiness->buscarPorNome($nomeRecurso, Recurso::TIPO_POSSIBILIDADE);
			$listaPotencialidades = array();
		}else{
			$listaPotencialidades = $this->recursoBusiness->buscarPorNome($nomeRecurso, Recurso::TIPO_POTENCIALIDADE);
			$listaPossibilidades = $this->recursoBusiness->buscarPorNome($nomeRecurso, Recurso::TIPO_POSSIBILIDADE);
		}

		return $this->view->render($response, "TemplatePainel.php", [
			"pagina" => "PainelControle.php",
			"listaPotencialidades" => $listaPotencialidades,
			"listaPossibilidades" => $listaPossibilidades,
			"nomeFiltro" => $nomeRecurso,
			"tipoFiltro" => $tipoRecurso,
		]);

	}

		

}
