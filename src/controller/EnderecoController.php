<?php
namespace Fluxa\Controller;
use Fluxa\Exception\BusinessException;
use Fluxa\Exception\ControlerException;
use FlyingLuscas\ViaCEP\ZipCode;

class EnderecoController {

	public function __construct() {

	}	

	public function getEndereco($request, $response, $args) {

		$cep = $request->getAttribute('cep');
		$pais = $request->getAttribute('pais');
		//$pais = "MEXICO";

		$ch = curl_init(); 

		if($pais == "BRASIL"){
			curl_setopt($ch, CURLOPT_URL, "https://viacep.com.br/ws/". $cep ."/json"); 
		}else if($pais == "MEXICO"){
			curl_setopt($ch, CURLOPT_URL, "https://api-codigos-postales.herokuapp.com/v2/codigo_postal/". $cep); 
		}		

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 

		$retorno = curl_exec($ch); 

		curl_close($ch);  

		return $retorno;

	}

	public function getCoordenadas($request, $response, $args){

		$logradouro = $request->getAttribute('log');
		$numero = $request->getAttribute('num');
		$bairro = $request->getAttribute('bai');
		$cidade = $request->getAttribute('cid');

		$adressValue = str_replace(" ", "+", $logradouro .",". $numero .",". $bairro .",". $cidade);

		$url = "https://maps.googleapis.com/maps/api/geocode/json?address=".$adressValue."&key=AIzaSyBQZKTit2ice6KDwHxAc5iQVZQhoBwimjw";

		$ch = curl_init(); 

		curl_setopt($ch, CURLOPT_URL, $url); 

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 

		$google_output = curl_exec($ch); 

		$jsonDecodificado = json_decode($google_output, true);

		$retorno = $jsonDecodificado["results"][0]["geometry"]["location"];

		curl_close($ch);  

		return json_encode($retorno); 

	}

}