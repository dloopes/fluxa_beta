<?php
namespace Fluxa\Entity;

use Fluxa\Entity\Usuario;
use Fluxa\Persistence\UsuarioDAO;

class FluxoMensagem {

	private $id;
	private $texto;
	private $id_fluxo;
	private $id_remetente;
	private $id_destinatario;
	private $date_insert;

	private $usuarioRemetente;
	private $usuarioDestinatario;

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

	public function getIdFluxo() {
		return $this->id_fluxo;
	}

	public function setIdFluxo($id_fluxo) {
		$this->id_fluxo = $id_fluxo;
	}

	public function getIdRemetente() {
		return $this->id_remetente;
	}

	public function setIdRemetente($id_remetente) {
		$this->id_remetente = $id_remetente;
	}

	public function getIdDestinatario() {
		return $this->id_destinatario;
	}

	public function setIdDestinatario($id_destinatario) {
		$this->id_destinatario = $id_destinatario;
	}

	public function getDateInsert() {
		return $this->date_insert;
	}

	public function getUsuarioRemetente(){
		
		if(empty($this->id_remetente)){
			return null;
		}

		if(empty($this->usuarioRemetente)){
			$usuarioDAO = new UsuarioDAO();
			$this->usuarioRemetente = $usuarioDAO->buscarUsuarioPorId($this->id_remetente);
		}		

		return $this->usuarioRemetente;

	}

	public function getUsuarioDestinatario(){

		if(empty($this->id_destinatario)){
			return null;
		}

		if(empty($this->usuarioDestinatario)){
			$usuarioDAO = new UsuarioDAO();
			$this->usuarioDestinatario = $usuarioDAO->buscarUsuarioPorId($this->id_destinatario);
		}		

		return $this->usuarioDestinatario;
	}

}