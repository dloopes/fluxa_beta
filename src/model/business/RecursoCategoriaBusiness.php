<?php
namespace Fluxa\Business;

use Fluxa\Exception\BusinessException;
use Fluxa\Entity\RecursoCategoria;
use Fluxa\Persistence\RecursoCategoriaDAO;

class RecursoCategoriaBusiness {

	private $daoRecursoCategoria;

	function __construct() {
		$this->daoRecursoCategoria = new RecursoCategoriaDAO();
	}

	public function buscarTodos() {

		return $this->daoRecursoCategoria->buscar();

	}

	public function buscarPorId($id) {

		return $this->daoRecursoCategoria->buscarPorId($id);

	}

}