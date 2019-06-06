<?php
namespace Fluxa\Controller;

use Fluxa\Entity\Recurso;
use Fluxa\Entity\Endereco;
use Fluxa\Entity\EnumRecursoStatus;
use Fluxa\Entity\EnumTiposFluxo;
use Fluxa\Business\RecursoBusiness;
use Fluxa\Business\RecursoCategoriaBusiness;
use Fluxa\Business\EnderecoBusiness;
use Fluxa\Exception\BusinessException;
use Fluxa\Exception\ControlerException;

class RecursoController {

	private $view;
	private $recursoBusiness;
	private $recursoCategoriaBusiness;
	private $enderecoBusiness;

	public function __construct($view) {
		$this->view = $view;
		$this->recursoBusiness = new RecursoBusiness();
		$this->recursoCategoriaBusiness = new RecursoCategoriaBusiness();
		$this->enderecoBusiness = new EnderecoBusiness();
	}

	public function postCadastroPotencialidade($request, $response, $args) {

		try{
			$dadosRequest = $request->getParsedBody();

			$id = $dadosRequest['id'];
			$nome = $dadosRequest['nome'];
			$detalhe = $dadosRequest['detalhe'];
			$idCategoria = $dadosRequest['id_categoria'];
			$status = $dadosRequest['status'];
			$tipoFluxo = $dadosRequest['tipo_fluxo'];

			$cep = $dadosRequest['cep'];
			$logradouro = $dadosRequest['logradouro'];
			$numero = $dadosRequest['numero'];
			$complemento = $dadosRequest['complemento'];
			$bairro = $dadosRequest['bairro'];
			$cidade = $dadosRequest['cidade'];
			$estado = $dadosRequest['uf'];
			$pais = $dadosRequest['pais'];

			if (empty($nome)) {
				throw new ControlerException("Nome é obrigatório");
			}

			if (empty($detalhe)) {
				throw new ControlerException("Detalhe é obrigatório");
			}

			if (empty($idCategoria)) {
				throw new ControlerException("Categoria é obrigatório");
			}

			if (empty($status)) {
				throw new ControlerException("Status é obrigatório");
			}

			if (empty($tipoFluxo)) {
				throw new ControlerException("Tipo do Fluxo é obrigatório");
			}

			if (empty($cep)) {
				throw new ControlerException("CEP é obrigatório");
			}

			if (empty($numero)) {
				throw new ControlerException("Número é obrigatório");
			}

			if (empty($logradouro) || empty($bairro) || empty($cidade) || empty($estado)) {
				throw new ControlerException("Informe um CEP válido");
			}

			$recurso = new Recurso();

			if(!empty($id)){
				$recurso = $this->recursoBusiness->buscarPorId($id);							
			}

			$endereco = $recurso->getEndereco();	
			$endereco->setCep($cep);
			$endereco->setLogradouro($logradouro);
			$endereco->setNumero($numero);
			$endereco->setComplemento($complemento);
			$endereco->setBairro($bairro);
			$endereco->setCidade($cidade);
			$endereco->setEstado($estado);
			$endereco->setPais($pais);

			$endereco = $this->enderecoBusiness->salvar($endereco);

			$recurso->setNome($nome);
			$recurso->setDetalhe($detalhe);
			$recurso->setIdCategoria($idCategoria);
			$recurso->setTipo(Recurso::TIPO_POTENCIALIDADE);
			$recurso->setIdUsuario($_SESSION['id']);
			$recurso->setStatus($status);
			$recurso->setTipoFluxo($tipoFluxo);
			$recurso->setIdEndereco($endereco->getId());

			$this->recursoBusiness->salvar($recurso);

			if(!empty($id)){
				$_SESSION['msg_sucesso'] = "Registro alterado com sucesso";

				return $response->withStatus(302)->withHeader('Location', URI_SISTEMA . 'potencialidades');
			}else{
				$_SESSION['msg_sucesso'] = "Cadastro realizado com sucesso";
				$this->getCadastroPotencialidade($request, $response, $args);
			}			

		} catch (ControlerException $ce) {
			$_SESSION['msg_alerta'] = $ce->getMessage();
			$this->getCadastroPotencialidade($request, $response, $args);
		} 

	}

	public function getPotencialidades($request, $response, $args) {
		
		$listaPotencialidades = $this->recursoBusiness->buscarPotencialidades();

		return $this->view->render($response, "TemplatePainel.php", [
			"pagina" => "MinhaListaPotencialidade.php", 
			"listaPotencialidades" => $listaPotencialidades
			]);

	}

	public function getPotencialidadesAll($request, $response, $args) {

		$numPag = $request->getAttribute('pag');
		
		$listaPotencialidades = $this->recursoBusiness->buscarPotencialidades(false);

		return $this->view->render($response, "TemplatePainel.php", [
			"pagina" => "ListaPotencialidade.php",
			"listaPotencialidades" => $listaPotencialidades,
			"numPag" => $numPag
			]);

	}

	public function getCadastroPotencialidade($request, $response, $args) {

		$idRecurso = $request->getAttribute('id');

		$recurso = new Recurso();

		if(!empty($idRecurso)){
			$recurso = $this->recursoBusiness->buscarPorId($idRecurso);
		}

		$listaCategorias = $this->recursoCategoriaBusiness->buscarTodos();
		$listaStatus = EnumRecursoStatus::toArray();
		$listaTiposFluxo = EnumTiposFluxo::toArray();

		return $this->view->render($response, "TemplatePainel.php", [
			"pagina" => "CadastroPotencialidade.php", 
			"listaCategorias" => $listaCategorias,
			"listaStatus" => $listaStatus,
			"listaTiposFluxo" => $listaTiposFluxo,
			"recurso" => $recurso
			]);

	}

	public function getPossibilidadeInativar($request, $response, $args) {

		$idRecurso = $request->getAttribute('id');

		if(empty($idRecurso)){
			throw new ControlerException("Id do recurso é obrigatório");
		}

		$recurso = $this->recursoBusiness->buscarPorId($idRecurso);

		if(empty($recurso)){
			throw new ControlerException("Recurso não encontrado");
		}

		$recurso->setStatus(EnumRecursoStatus::INDISPO);

		$recurso = $this->recursoBusiness->salvar($recurso);

		$_SESSION['msg_sucesso'] = "Registro salvo com sucesso";
		$this->getPossibilidades($request, $response, $args);

	}

	public function postCadastroPossibilidade($request, $response, $args) {

		try{
			$dadosRequest = $request->getParsedBody();

			$id = $dadosRequest['id'];
			$nome = $dadosRequest['nome'];
			$detalhe = $dadosRequest['detalhe'];
			$idCategoria = $dadosRequest['id_categoria'];
			$status = $dadosRequest['status'];
			$tipoFluxo = $dadosRequest['tipo_fluxo'];

			$cep = $dadosRequest['cep'];
			$logradouro = $dadosRequest['logradouro'];
			$numero = $dadosRequest['numero'];
			$complemento = $dadosRequest['complemento'];
			$bairro = $dadosRequest['bairro'];
			$cidade = $dadosRequest['cidade'];
			$estado = $dadosRequest['uf'];
			$pais = $dadosRequest['pais'];

			if (empty($nome)) {
				throw new ControlerException("Nome é obrigatório");
			}

			if (empty($detalhe)) {
				throw new ControlerException("Detalhe é obrigatório");
			}

			if (empty($idCategoria)) {
				throw new ControlerException("Categoria é obrigatório");
			}

			if (empty($status)) {
				throw new ControlerException("Status é obrigatório");
			}

			if (empty($tipoFluxo)) {
				throw new ControlerException("Tipo de Fluxo é obrigatório");
			}

			if (empty($cep)) {
				throw new ControlerException("CEP é obrigatório");
			}

			if (empty($numero)) {
				throw new ControlerException("Número é obrigatório");
			}

			if (empty($logradouro) || empty($bairro) || empty($cidade) || empty($estado)) {
				throw new ControlerException("Informe um CEP válido");
			}

			$recurso = new Recurso();

			if(!empty($id)){
				$recurso = $this->recursoBusiness->buscarPorId($id);							
			}

			$endereco = $recurso->getEndereco();	
			$endereco->setCep($cep);
			$endereco->setLogradouro($logradouro);
			$endereco->setNumero($numero);
			$endereco->setComplemento($complemento);
			$endereco->setBairro($bairro);
			$endereco->setCidade($cidade);
			$endereco->setEstado($estado);
			$endereco->setPais($pais);

			$endereco = $this->enderecoBusiness->salvar($endereco);

			$recurso = new Recurso();

			if(!empty($id)){
				$recurso = $this->recursoBusiness->buscarPorId($id);
			}

			$recurso->setNome($nome);
			$recurso->setDetalhe($detalhe);
			$recurso->setIdCategoria($idCategoria);
			$recurso->setTipo(Recurso::TIPO_POSSIBILIDADE);
			$recurso->setIdUsuario($_SESSION['id']);
			$recurso->setStatus($status);
			$recurso->setTipoFluxo($tipoFluxo);
			$recurso->setIdEndereco($endereco->getId());

			$this->recursoBusiness->salvar($recurso);

			if(!empty($id)){
				$_SESSION['msg_sucesso'] = "Registro alterado com sucesso";

				return $response->withStatus(302)->withHeader('Location', URI_SISTEMA . 'possibilidades');
			}else{
				$_SESSION['msg_sucesso'] = "Cadastro realizado com sucesso";
				$this->getCadastroPossibilidade($request, $response, $args);
			}			

		} catch (ControlerException $ce) {
			$_SESSION['msg_alerta'] = $ce->getMessage();
			$this->getCadastroPossibilidade($request, $response, $args);
		} 

	}

	public function getPossibilidades($request, $response, $args) {
		
		$listaPossibilidades = $this->recursoBusiness->buscarPossibilidades();

		return $this->view->render($response, "TemplatePainel.php", [
			"pagina" => "MinhaListaPossibilidade.php", 
			"listaPossibilidades" => $listaPossibilidades
			]);

	}

	public function getPossibilidadesAll($request, $response, $args) {

		$numPag = $request->getAttribute('pag');
		
		$listaPossibilidades = $this->recursoBusiness->buscarPossibilidades(false);

		return $this->view->render($response, "TemplatePainel.php", [
			"pagina" => "ListaPossibilidade.php",
			"listaPossibilidades" => $listaPossibilidades,
			"numPag" => $numPag
			]);

	}

	public function getCadastroPossibilidade($request, $response, $args) {

		$idRecurso = $request->getAttribute('id');

		$recurso = new Recurso();

		if(!empty($idRecurso)){
			$recurso = $this->recursoBusiness->buscarPorId($idRecurso);
		}

		$listaCategorias = $this->recursoCategoriaBusiness->buscarTodos();
		$listaStatus = EnumRecursoStatus::toArray();
		$listaTiposFluxo = EnumTiposFluxo::toArray();

		return $this->view->render($response, "TemplatePainel.php", [
			"pagina" => "CadastroPossibilidade.php", 
			"listaCategorias" => $listaCategorias,
			"listaStatus" => $listaStatus,
			"listaTiposFluxo" => $listaTiposFluxo,
			"recurso" => $recurso
			]);

	}


	public function getPotencialidadeInativar($request, $response, $args) {

		$idRecurso = $request->getAttribute('id');

		if(empty($idRecurso)){
			throw new ControlerException("Id do recurso é obrigatório");
		}

		$recurso = $this->recursoBusiness->buscarPorId($idRecurso);

		if(empty($recurso)){
			throw new ControlerException("Recurso não encontrado");
		}

		$recurso->setStatus(EnumRecursoStatus::INDISPO);

		$recurso = $this->recursoBusiness->salvar($recurso);

		$_SESSION['msg_sucesso'] = "Registro salvo com sucesso";

		$this->getPotencialidades($request, $response, $args);

	}

	public function getDiferentesNomesDeRecursos($request, $response, $args) {

		$params = $request->getQueryParams();

		$query = $params['query'];

		$listaNomes = $this->recursoBusiness->buscaNomesRecurso($query);

		$recursos = array();

		foreach ($listaNomes as $itemLista) {

			$item['label'] = $itemLista['nome'];

			$recursos[] = $item;

		}

		return json_encode($recursos);

	}

	public function getMapaRecursos($request, $response, $args){
		
		$nomeRecurso = $request->getAttribute('nome');
		$tipoRecurso = null;

		$listaPotencialidades = array();
		$listaPossibilidades = array();

		switch ($request->getAttribute('tipo')) {
			case 'potencialidade':
				$tipoRecurso = Recurso::TIPO_POTENCIALIDADE;
				$listaPotencialidades = $this->recursoBusiness->buscarPorNome($nomeRecurso, Recurso::TIPO_POTENCIALIDADE);
				break;
			case 'possibilidade':
				$tipoRecurso = Recurso::TIPO_POSSIBILIDADE;
				$listaPossibilidades = $this->recursoBusiness->buscarPorNome($nomeRecurso, Recurso::TIPO_POSSIBILIDADE);
				break;
			default:
				break;
		}		

		return $this->view->render($response, "TemplatePainel.php", [
			"pagina" => "MapaRecursos.php", 
			"listaPotencialidades" => $listaPotencialidades,
			"listaPossibilidades" => $listaPossibilidades,
			"nomeRecurso" => $nomeRecurso,
			"tipoRecurso" => $tipoRecurso
			]);
	}

	public function getMapaRecursosId($request, $response, $args){
		
		$idRecurso = $request->getAttribute('id');

		$recurso = $this->recursoBusiness->buscarPorId($idRecurso, false);

		$listaPossibilidades = array();
		$listaPotencialidades = array();

		if(empty($recurso)){

			$_SESSION['msg_alerta'] = "Recurso não encontrado";

			return $this->view->render($response, "TemplatePainel.php", [
				"pagina" => "DetalheRecurso.php", 
				"listaPotencialidades" => $listaPotencialidades,
				"listaPossibilidades" => $listaPossibilidades
				]);
		
		}else{

			if($recurso->getTipo() == Recurso::TIPO_POTENCIALIDADE){			
				$listaPotencialidades = array($recurso);
			}else{			
				$listaPossibilidades = array($recurso);
			}

			$tipoRecurso = $recurso->getTipoFluxo();
			$nomeRecurso = $recurso->getNome();
			$endereco = $recurso->getEndereco();

			return $this->view->render($response, "TemplatePainel.php", [
				"pagina" => "DetalheRecurso.php", 
				"listaPotencialidades" => $listaPotencialidades,
				"listaPossibilidades" => $listaPossibilidades,
				"nomeRecurso" => $nomeRecurso,
				"tipoRecurso" => $tipoRecurso,
				"recurso" => $recurso,
				"latitudeDefault" => $endereco->getLatitude(),
				"longitudeDefault" => $endereco->getLongitude(),
				"zoomDefault" => 12,
				"recurso" => $recurso
				]);

		}	

		
	}

}