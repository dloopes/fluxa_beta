<?php
use Fluxa\Controller\EnderecoController as EnderecoController;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

$app->get('/endereco/{cep}', function (Request $request, Response $response, array $args) {
	$controller = new EnderecoController();
	return $controller->getEndereco($request, $response, $args);
});

$app->get('/endereco/coordenadas/{log}/{num}/{bai}/{cid}', function (Request $request, Response $response, array $args) {
	$controller = new EnderecoController();
	return $controller->getCoordenadas($request, $response, $args);
});