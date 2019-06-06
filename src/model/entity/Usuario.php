<?php
namespace Fluxa\Entity;

class Usuario {

	protected $table = 'usuario';

	const USUARIO_FACEBOOK = "facebook";
	const USUARIO_GOOGLE = "google";
	const USUARIO_DEFAULT = "default";

	private $id;

	private $idRedeSocial;

	private $nome;

	private $email;

	private $url_imagem;

	private $senha;

	private $perfil;

	private $data_cadastro;

	private $data_ultimo_acesso;

	private $d_e_l_e_t_;

	private $chave_cadastro;

	private $email_confirmado;

	private $chave_recuperar_senha;

	private $recuperar_senha;

	public function getId() {

		return $this->id;

	}

	public function setId($id) {

		$this->id = $id;

	}

	public function getIdRedeSocial() {

		return $this->idRedeSocial;

	}

	public function setIdRedeSocial($idRedeSocial) {

		$this->idRedeSocial = $idRedeSocial;

	}

	public function getNome() {

		return $this->nome;

	}

	public function setNome($nome) {

		$this->nome = $nome;

	}

	public function getEmail() {

		return $this->email;

	}

	public function setEmail($email) {

		$this->email = $email;

	}

	public function getUrlImagem() {

		if(empty($this->url_imagem)){
			return URI_SISTEMA .'dist/template/img/profile2.png';
		}

		return $this->url_imagem;

	}

	public function setUrlImagem($url_imagem) {

		$this->url_imagem = $url_imagem;

	}

	public function getSenha() {

		return $this->senha;

	}

	public function setSenha($senha) {

		if (!empty($senha)) {
			$this->senha = md5($senha);
		} else {
			$this->senha = "";
		}

	}

	public function getPerfil() {

		return $this->perfil;

	}

	public function setPerfil($perfil) {

		$this->perfil = $perfil;

	}

	public function getDataCadastro() {

		return $this->data_cadastro;

	}

	public function setDataCadastro($data_cadastro) {

		$this->data_cadastro = $data_cadastro;

	}

	public function getDataUltimoAcesso() {

		return $this->data_ultimo_acesso;

	}

	public function setDataUltimoAcesso($data_ultimo_acesso) {

		$this->data_ultimo_acesso = $data_ultimo_acesso;

	}

	public function getDelete() {

		return $this->d_e_l_e_t_;

	}

	public function setDelete($d_e_l_e_t_) {

		$this->d_e_l_e_t_ = $d_e_l_e_t_;

	}

	public function getDataCadastroView() {

		return (date('d/m/Y', strtotime($this->data_cadastro)));

	}

	public function getDataUltimoAcessoView() {

		return (date('d/m/Y', strtotime($this->data_ultimo_acesso)));

	}

	public function getChaveCadastro() {

		return $this->chave_cadastro;

	}

	public function setChaveCadastro($chave_cadastro) {

		$this->chave_cadastro = $chave_cadastro;

	}

	public function isEmailConfirmado() {

		return $this->email_confirmado;

	}

	public function setEmailConfirmado($email_confirmado) {

		$this->email_confirmado = $email_confirmado;

	}

	public function isRecuperarSenha() {

		return $this->recuperar_senha;

	}

	public function setRecuperarSenha($recuperar_senha) {

		$this->recuperar_senha = $recuperar_senha;

	}

	public function getChaveRecuperarSenha() {

		return $this->chave_recuperar_senha;

	}

	public function setChaveRecuperarSenha($chave_recuperar_senha) {

		$this->chave_recuperar_senha = $chave_recuperar_senha;

	}

	public function gerarChaveCadastro() {

		if (empty($this->email) || empty($this->nome) || empty($this->id)) {
			return null;
		}

		$this->chave_cadastro = md5($this->email . $this->nome . $this->id);

		return $this->chave_cadastro;
	}

	public function gerarChaveRecuperarSenha() {

		if (empty($this->email) || empty($this->nome) || empty($this->id)) {
			return null;
		}

		$this->chave_recuperar_senha = md5($this->email . $this->nome . $this->id);

		return $this->chave_recuperar_senha;
	}

}

?>
