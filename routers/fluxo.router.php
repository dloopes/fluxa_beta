<?php
use Fluxa\Controller\FluxoController as FluxoController;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

$app->post('/fluxo[/]', function (Request $request, Response $response, array $args) {
	$controller = new FluxoController($this->view);
	return $controller->postFluxo($request, $response, $args);
});

$app->post('/fluxo/status[/]', function (Request $request, Response $response, array $args) {
	$controller = new FluxoController($this->view);
	return $controller->postFluxoStatus($request, $response, $args);
});

$app->get('/fluxo/{id_fluxo}', function (Request $request, Response $response, array $args) {
	$controller = new FluxoController($this->view);
	return $controller->getFluxo($request, $response, $args);
});

$app->get('/fluxos[/]', function (Request $request, Response $response, array $args) {
	$controller = new FluxoController($this->view);
	return $controller->getMeusFluxos($request, $response, $args);
});

$app->post('/fluxo/mensagem[/]', function (Request $request, Response $response, array $args) {
	$controller = new FluxoController($this->view);
	return $controller->postFluxoMensagem($request, $response, $args);
});