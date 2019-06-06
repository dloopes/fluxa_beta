<?php
use Fluxa\Controller\PainelController as PainelController;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;


$app->get('/painel[/[{tipo}]]', function ($request, $response, $args) {
	$controller = new PainelController($this->view);
	return $controller->getPainel($request, $response, $args);
});

$app->post('/painel/filtro', function ($request, $response, $args) {
	$controller = new PainelController($this->view);
	return $controller->postPainel($request, $response, $args);
});