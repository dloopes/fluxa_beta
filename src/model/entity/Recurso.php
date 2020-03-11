<?php
namespace Fluxa\Entity;

use Fluxa\Entity\RecursoCategoria;
use Fluxa\Entity\Endereco;
use Fluxa\Entity\Usuario;
use Fluxa\Persistence\RecursoCategoriaDAO;
use Fluxa\Persistence\EnderecoDAO;
use Fluxa\Persistence\UsuarioDAO;

class Recurso {

	const TIPO_POTENCIALIDADE = "potencialidade";
	const TIPO_POSSIBILIDADE = "possibilidade";
	const TIPO_INICIATIVA = "iniciativa";

	protected $table = 'recurso';

	private $id;

	private $nome;

	private $detalhe;

	private $tipo_recurso;

	private $id_categoria;

	private $id_usuario;

	private $id_endereco;

	private $categoria;

	private $usuario;

	private $endereco;

	private $status;

	private $tipo_fluxo;

	public function __construct(){

	}

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

	public function getDetalhe() {

		return $this->detalhe;

	}

	public function setDetalhe($detalhe) {

		$this->detalhe = $detalhe;

	}

	public function getTipo() {

		return $this->tipo_recurso;

	}

	public function setTipo($tipo_recurso) {

		$this->tipo_recurso = $tipo_recurso;

	}

	public function getIdCategoria() {

		return $this->id_categoria;

	}

	public function setIdCategoria($id_categoria) {

		$this->id_categoria = $id_categoria;

	}

	public function getIdUsuario() {

		return $this->id_usuario;

	}

	public function setIdUsuario($id_usuario) {

		$this->id_usuario = $id_usuario;

	}

	public function getIdEndereco() {

		return $this->id_endereco;

	}

	public function setIdEndereco($id_endereco) {

		$this->id_endereco = $id_endereco;

	}

	public function getStatus() {

		return $this->status;

	}

	public function getStatusView() {

		return $this->status;

	}

	public function setStatus($status) {

		$this->status = $status;

	}

	public function getTipoFluxo() {

		return $this->tipo_fluxo;

	}

	public function setTipoFluxo($tipo_fluxo) {

		$this->tipo_fluxo = $tipo_fluxo;

	}

	public function getCategoria() {

		if(empty($this->id_categoria)){
			return null;
		}

		if(empty($this->categoria)){
			//Buscar categoria
			$recursoCategoriaDAO = new RecursoCategoriaDAO();
			$this->categoria = $recursoCategoriaDAO->buscarPorId($this->id_categoria);
		}		

		return $this->categoria;

	}

	public function getEndereco() {

		if(empty($this->id_endereco)){
			return new Endereco();
		}

		if(empty($this->endereco)){
			//Buscar categoria
			$enderecoDAO = new EnderecoDAO();
			$this->endereco = $enderecoDAO->buscarPorId($this->id_endereco);
		}		

		return $this->endereco;

	}

	public function getUsuario() {

		if(empty($this->id_usuario)){
			return new Usuario();
		}

		if(empty($this->usuario)){
			//Buscar categoria
			$usuarioDAO = new UsuarioDAO();
			$this->usuario = $usuarioDAO->buscarUsuarioPorId($this->id_usuario);
		}		

		return $this->usuario;

	}	

}

?>