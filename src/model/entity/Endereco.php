<?php
namespace Fluxa\Entity;

class Endereco {

	private $id;

	private $cep;

	private $logradouro;

	private $numero;

	private $complemento;

	private $bairro;

	private $cidade;

	private $estado;

	private $pais;

	private $latitude;

	private $longitude;

	public function getId() {

		return $this->id;

	}

	public function setId($id) {

		$this->id = $id;

	}

	public function getCep() {

		return $this->cep;

	}

	public function setCep($cep) {

		$this->cep = $cep;

	}

	public function getLogradouro() {

		return $this->logradouro;

	}

	public function setLogradouro($logradouro) {

		$this->logradouro = $logradouro;

	}

	public function getNumero() {

		return $this->numero;

	}

	public function setNumero($numero) {

		$this->numero = $numero;

	}

	public function getComplemento() {

		return $this->complemento;

	}

	public function setComplemento($complemento) {

		$this->complemento = $complemento;

	}

	public function getBairro() {

		return $this->bairro;

	}

	public function setBairro($bairro) {

		$this->bairro = $bairro;

	}

	public function getCidade() {

		return $this->cidade;

	}

	public function setCidade($cidade) {

		$this->cidade = $cidade;

	}

	public function getPais() {

		return $this->pais;

	}

	public function setPais($pais) {

		$this->pais = $pais;

	}

	public function getEstado() {

		return $this->estado;

	}

	public function setEstado($estado) {

		$this->estado = $estado;

	}

	public function getLatitude() {

		return $this->latitude;

	}

	public function setLatitude($latitude) {

		$this->latitude = $latitude;

	}

	public function getLongitude() {

		return $this->longitude;

	}

	public function setLongitude($longitude) {

		$this->longitude = $longitude;

	}


}