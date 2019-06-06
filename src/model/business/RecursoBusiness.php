<?php
namespace Fluxa\Business;

use Fluxa\Business\EnderecoBusiness;
use Fluxa\Exception\BusinessException;
use Fluxa\Entity\Recurso;
use Fluxa\Persistence\RecursoDAO;
use Fluxa\Entity\Usuario;

class RecursoBusiness {

	private $daoRecurso;

	function __construct() {
		$this->daoRecurso = new RecursoDAO();
	}

	public function salvar(Recurso $recurso) {

		if (empty($recurso) || empty($recurso->getNome())) {
			throw new BusinessException("Nome não pode ser nulo");
			return null;
		}

		return $this->daoRecurso->salvar($recurso);

	}

	public function buscarPotencialidades($sohDoUsuarioLogado = true, $qtdeMaxRegistros = null) {

		if($sohDoUsuarioLogado){
			return $this->daoRecurso->buscarPotencialidades($_SESSION['id']);
		}else{
			return $this->daoRecurso->buscarPotencialidades(null, $qtdeMaxRegistros, true);
		}
		

	}

	public function buscarPossibilidades($sohDoUsuarioLogado = true, $qtdeMaxRegistros = null) {

		if($sohDoUsuarioLogado){
			return $this->daoRecurso->buscarPossibilidades($_SESSION['id']);
		}else{
			return $this->daoRecurso->buscarPossibilidades(null, 	$qtdeMaxRegistros, true);
		}		

	}

	public function buscarPotencialidadesPorUsuario($idUsuario) {

		if (empty($idUsuario)) {
			throw new BusinessException("Parâmetro inválido");
			return null;
		}

		return $this->daoRecurso->buscarPotencialidades($idUsuario, null, true);

	}

	public function buscarPossibilidadesPorUsuario($idUsuario) {

		if (empty($idUsuario)) {
			throw new BusinessException("Parâmetro inválido");
			return null;
		}

		return $this->daoRecurso->buscarPossibilidades($idUsuario, null, true);

	}

	public function buscarPorId($id, $sohDoUsuarioLogado = true) {

		if($sohDoUsuarioLogado){
			return $this->daoRecurso->buscarPorId($id, $_SESSION['id']);
		}else{
			return $this->daoRecurso->buscarPorId($id);
		}	
		

	}

	public function buscarPorNome($nome, $tipoRecurso = null) {

		if (empty($nome)) {
			throw new BusinessException("Parâmetro inválido");
		}

		return $this->daoRecurso->buscarPorNome($nome, $tipoRecurso, true);

	}

	public function buscaNomesRecurso($nome){

		return $this->daoRecurso->buscaNomesRecurso($nome);
		
	}

	public function remover(Recurso $recurso) {

		if (empty($recurso) || empty($recurso->getId())) {
			throw new BusinessException("Id não pode ser nulo");
			return false;
		}

		$this->daoRecurso->remover($recurso);
		
		$enderecoBusiness = new EnderecoBusiness();
		$enderecoBusiness->remover($recurso->getEndereco());		

		return true;

	}

	public function getQtdeTotalRecursos($tipoRecurso = null){

		return $this->daoRecurso->getQtdeTotalRecursos($tipoRecurso, true);

	}

	public function getQtdeTotalRecursosPorUsuario($idUsuario, $tipoRecurso = null) {

		if(empty($idUsuario)){
			return 0;
		}

		return $this->daoRecurso->getQtdeTotalRecursosPorUsuario($idUsuario, $tipoRecurso, true);

	}

}