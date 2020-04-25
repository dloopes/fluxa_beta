<?php
namespace Fluxa\Entity;

use Fluxa\Entity\Usuario;
use Fluxa\Entity\Recurso;
use Fluxa\Persistence\UsuarioDAO;
use Fluxa\Persistence\RecursoDAO;

class Fluxo {

	const STATUS_POTENCIAL = "Potencial";
	const STATUS_REALIZADO = "Realizado";
	const STATUS_INTERROMPIDO = "Interrompido";

	private $id;

	private $id_usuario_oferece;

	private $id_usuario_necessita;

	private $id_recurso;

	private $status;

	private $date_insert;

	private $date_update;

	private $recurso;

	private $usuarioOferece;

	private $usuarioNecessita;
        
    public $id_recurso_necessita = null;


	public function getId() {

		return $this->id;

	}

	public function setId($id) {

		$this->id = $id;

	}

	public function setIdUsuarioOferece($id_usuario_oferece) {

		$this->id_usuario_oferece = $id_usuario_oferece;

	}

	public function getIdUsuarioOferece() {

		return $this->id_usuario_oferece;

	}

	public function setViewUsuarioOferece($view_usuario_oferece) {

		$this->view_usuario_oferece = $view_usuario_oferece;

	}

	public function getViewUsuarioOferece() {

		return $this->view_usuario_oferece;

	}


	public function setIdUsuarioNecessita($id_usuario_necessita) {

		$this->id_usuario_necessita = $id_usuario_necessita;

	}

	public function getIdUsuarioNecessita() {

		return $this->id_usuario_necessita;

	}

	public function setViewUsuarioNecessita($view_usuario_necessita) {

		$this->view_usuario_necessita = $view_usuario_necessita;

	}

	public function getViewUsuarioNecessita() {

		return $this->view_usuario_necessita;

	}

	public function setIdRecurso($id_recurso) {

		$this->id_recurso = $id_recurso;

	}

	public function getIdRecurso() {

		return $this->id_recurso;

	}

	public function setStatus($status) {

		$this->status = $status;

	}

	public function getStatus() {

		return $this->status;

	}

	public function setDateInsert($date_insert) {

		$this->date_insert = $date_insert;

	}

	public function getDateInsert() {

		return $this->date_insert;

	}

	public function setDateUpdate($date_update) {

		$this->date_update = $date_update;

	}

	public function getDateUpdate() {

		return $this->date_update;

	}

	public function getRecurso(){

		if(empty($this->id_recurso)){
			return null;
		}

		if(empty($this->recurso)){
			$recursoDAO = new RecursoDAO();
			$this->recurso = $recursoDAO->buscarPorId($this->id_recurso);
		}		

		return $this->recurso;

	}

	public function getUsuarioNecessita(){
		
		if(empty($this->id_usuario_necessita)){
			return null;
		}

		if(empty($this->usuarioNecessita)){
			$usuarioDAO = new UsuarioDAO();
			$this->usuarioNecessita = $usuarioDAO->buscarUsuarioPorId($this->id_usuario_necessita);
		}		

		return $this->usuarioNecessita;

	}

	public function getUsuarioOferece(){

		if(empty($this->id_usuario_oferece)){
			return null;
		}

		if(empty($this->usuarioOferece)){
			$usuarioDAO = new UsuarioDAO();
			$this->usuarioOferece = $usuarioDAO->buscarUsuarioPorId($this->id_usuario_oferece);
		}		

		return $this->usuarioOferece;

	}

	public function getMensagemDoFluxo(){

		if(empty($this->usuarioNecessita)){
			$this->getUsuarioNecessita();
		}

		if(empty($this->usuarioOferece)){
			$this->getUsuarioOferece();
		}

		if(empty($this->recurso)){
			$this->getRecurso();
		}

		$quemNecessita = $this->usuarioNecessita->getNome();

		if($this->usuarioNecessita->getId() == $_SESSION['id']){
			$quemNecessita = "você";
		}

		$quemOferece = $this->usuarioOferece->getNome();

		if($this->usuarioOferece->getId() == $_SESSION['id']){
			$quemOferece = "você";
		}

		$mensagem = "";
		$mensagem = "<a href='".URI_SISTEMA."usuario/".$this->usuarioOferece->getId()."' data-toggle='tooltip' title='".$this->usuarioOferece->getEmail()."'>".ucfirst($quemOferece)."</a> ofereceu <b>".$this->getRecurso()->getNome()."</b> necessitado por <a href='".URI_SISTEMA."usuario/".$this->usuarioNecessita->getId()."' data-toggle='tooltip' title='".$this->usuarioNecessita->getEmail()."'>".ucfirst($quemNecessita)."</a>";
	
		if($this->recurso->getTipo() == Recurso::TIPO_POTENCIALIDADE){
                       //$mensagem = "<a href='".URI_SISTEMA."usuario/".$this->usuarioNecessita->getId()."' data-toggle='tooltip' title='".$this->usuarioNecessita->getEmail()."'>".ucfirst($quemNecessita)."</a> solicitou <b>".$this->getRecurso()->getNome()."</b> ofertado por <a href='".URI_SISTEMA."usuario/".$this->usuarioOferece->getId()."' data-toggle='tooltip' title='".$this->usuarioOferece->getEmail()."'>".ucfirst($quemOferece)."</a>";
	
		}

		if($this->recurso->getTipo() == Recurso::TIPO_POSSIBILIDADE){
		//	$mensagem = "<a href='".URI_SISTEMA."usuario/".$this->usuarioOferece->getId()."' data-toggle='tooltip' title='".$this->usuarioOferece->getEmail()."'>".ucfirst($quemOferece)."</a> ofereceu <b>".$this->getRecurso()->getNome()."</b> necessitado por <a href='".URI_SISTEMA."usuario/".$this->usuarioNecessita->getId()."' data-toggle='tooltip' title='".$this->usuarioNecessita->getEmail()."'>".ucfirst($quemNecessita)."</a>";
	
                    
                }	

		if ( $mensagem == ""){
					$mensagem = "<a href='".URI_SISTEMA."usuario/".$this->usuarioOferece->getId()."' data-toggle='tooltip' title='".$this->usuarioOferece->getEmail()."'>".ucfirst($quemOferece)."</a> ofereceu <b>".$this->getRecurso()->getNome()."</b> necessitado por <a href='".URI_SISTEMA."usuario/".$this->usuarioNecessita->getId()."' data-toggle='tooltip' title='".$this->usuarioNecessita->getEmail()."'>".ucfirst($quemNecessita)."</a>";
		}	

		return $mensagem;

	}

	public function getMensagemSimplesDoFluxo(){

		if(empty($this->usuarioNecessita)){
			$this->getUsuarioNecessita();
		}

		if(empty($this->usuarioOferece)){
			$this->getUsuarioOferece();
		}

		if(empty($this->recurso)){
			$this->getRecurso();
		}

		$quemNecessita = $this->usuarioNecessita->getNome();

		if($this->usuarioNecessita->getId() == $_SESSION['id']){
			$quemNecessita = "você";
		}

		$quemOferece = $this->usuarioOferece->getNome();

		if($this->usuarioOferece->getId() == $_SESSION['id']){
			$quemOferece = "você";
		}

		$mensagem = "";

		if($this->recurso->getTipo() == Recurso::TIPO_POTENCIALIDADE){
			$mensagem = ucfirst($quemNecessita)." solicitou <b>".$this->getRecurso()->getNome()."</b> ofertado por ".ucfirst($quemOferece);
		}

		if($this->recurso->getTipo() == Recurso::TIPO_POSSIBILIDADE){
			$mensagem = ucfirst($quemOferece)." ofereceu <b>".$this->getRecurso()->getNome()."</b> necessitado por ".ucfirst($quemNecessita);
		}	

		if ( $mensagem ==""){

			$mensagem = ucfirst($quemOferece)." ofereceu <b>".$this->getRecurso()->getNome()."</b> necessitado por ".ucfirst($quemNecessita);
		}	

		return $mensagem;

	}

	public function getUsuarioIniciouFluxo(){

		if(empty($this->recurso)){
			$this->getRecurso();
		}

		if($this->recurso->getTipo() == Recurso::TIPO_POTENCIALIDADE){
			return $this->getUsuarioNecessita();
		}else if($this->recurso->getTipo() == Recurso::TIPO_POSSIBILIDADE){
			return $this->getUsuarioOferece();
		}	


			return $this->getUsuarioNecessita();

	}

	public function getUsuarioRecebeuFluxo(){

		if(empty($this->recurso)){
			$this->getRecurso();
		}

		if($this->recurso->getTipo() == Recurso::TIPO_POTENCIALIDADE){
			return $this->getUsuarioOferece();
		}else if($this->recurso->getTipo() == Recurso::TIPO_POSSIBILIDADE){
			return $this->getUsuarioNecessita();			
		}	


			return $this->getUsuarioOferece();

	}

	public function getUsuariosFluxo(){
		
		$usuariosList = array();
		
		$usuariosList[] = $this->getUsuarioOferece();
		$usuariosList[] = $this->getUsuarioNecessita();	

		return $usuariosList;
		
	}

}