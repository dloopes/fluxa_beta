<?php
namespace Fluxa\Entity;

class RecursoCategoria {

	protected $table = 'recurso_categoria';

	private $id;

	private $nome;

	public function getId() {

		return $this->id;

	}

	public function setId($id) {

		$this->id = $id;

	}

	public function getNome() {

		return $this->nome;

	}

	public function setNome($nome) {

		$this->nome = $nome;

	}

}

?>
