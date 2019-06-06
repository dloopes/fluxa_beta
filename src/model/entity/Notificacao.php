<?php
namespace Fluxa\Entity;

use Fluxa\Entity\Usuario;
use Fluxa\Persistence\UsuarioDAO;

class Notificacao {

	private $id;
	private $texto;
	private $tipo;
	private $id_usuario;
	private $visualizado;
	private $dateInsert;
	private $url;

	private $usuario;

	public function __construct($texto = null, $tipo= null, $idUsuario= null, $url= null){

		if(!empty($texto)){
			$this->texto = $texto;
		}

		if(!empty($tipo)){
			$this->tipo = $tipo;
		}

		if(!empty($idUsuario)){
			$this->id_usuario = $idUsuario;
		}

		if(!empty($url)){
			$this->url = $url;
		}

	}

	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function getTexto() {
		return $this->texto;
	}

	public function setTexto($texto) {
		$this->texto = $texto;
	}

	public function getTipo() {
		return $this->tipo;
	}

	public function setTipo($tipo) {
		$this->tipo = $tipo;
	}

	public function getIdUsuario() {
		return $this->id_usuario;
	}

	public function setIdUsuario($id_usuario) {
		$this->id_usuario = $id_usuario;
	}

	public function getVisualizado() {
		return $this->visualizado;
	}

	public function setVisualizado($visualizado) {
		$this->visualizado = $visualizado;
	}

	public function getDateInsert() {
		return $this->date_insert;
	}

	public function getUrl() {
		return $this->url;
	}

	public function setUrl($url) {
		$this->url = $url;
	}

	public function getUsuario(){
		
		if(empty($this->id_usuario)){
			return null;
		}

		if(empty($this->usuario)){
			$usuarioDAO = new UsuarioDAO();
			$this->usuarioNecessita = $usuarioDAO->buscarUsuarioPorId($this->id_usuario);
		}		

		return $this->usuarioNecessita;

	}

}