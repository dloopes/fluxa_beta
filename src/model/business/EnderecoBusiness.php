<?php
namespace Fluxa\Business;

use Fluxa\Exception\BusinessException;
use Fluxa\Entity\Endereco;
use Fluxa\Persistence\EnderecoDAO;

class EnderecoBusiness {

	private $daoEndereco;

	function __construct() {
		$this->daoEndereco = new EnderecoDAO();
	}

	public function salvar(Endereco $endereco) {

		if (empty($endereco)) {
			throw new BusinessException("Parâmetro endereço não pode ser nulo");
		}

		$endereco = $this->updateCoordenadasEndereco($endereco);

		return $this->daoEndereco->salvar($endereco);

	}

	public function buscarPorId($idEndereco) {

		return $this->daoEndereco->buscarPorId($idEndereco);

	}

	public function remover(Endereco $endereco) {

		if (empty($endereco) || empty($endereco->getId())) {
			throw new BusinessException("Id não pode ser nulo");
			return false;
		}

		$this->daoEndereco->remover($endereco);

		return true;

	}

	private function updateCoordenadasEndereco(Endereco $endereco){

		$adressValue = str_replace(" ", "+", $endereco->getLogradouro() .",". $endereco->getNumero() .",". $endereco->getBairro() .",". $endereco->getCidade().",". $endereco->getEstado());

		$url = "https://maps.googleapis.com/maps/api/geocode/json?address=".$adressValue."&key=AIzaSyBQZKTit2ice6KDwHxAc5iQVZQhoBwimjw";

        if ( function_exists("curl_init")){

        		$ch = curl_init(); 

				curl_setopt($ch, CURLOPT_URL, $url); 

				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 

				$google_output = curl_exec($ch); 

				$jsonDecodificado = json_decode($google_output, true);

				$endereco->setLatitude($jsonDecodificado["results"][0]["geometry"]["location"]["lat"]);
				$endereco->setLongitude($jsonDecodificado["results"][0]["geometry"]["location"]["lng"]);

				curl_close($ch);

        } else {


			$result = file_get_contents($url);
			$jsonDecodificado = json_decode($result, true);
			

            $endereco->setLatitude($jsonDecodificado["results"][0]["geometry"]["location"]["lat"]);
			$endereco->setLongitude($jsonDecodificado["results"][0]["geometry"]["location"]["lng"]);

			/* print_r( $result ); die(" ");

			$output = array (
				'temperature' => bm_getWeatherProperties('temp', $result),
				'weather' => bm_getWeatherProperties('text', $result),
				'weather_code' => bm_getWeatherProperties('code', $result),
				'class' => 'weatherIcon-' . bm_getWeatherProperties('code', $result),
			);

			return $output; */



        }
	

		return $endereco;
	}

}