<?php
use Fluxa\Controller\RecursoController as RecursoController;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

$app->get('/potencialidades/all/{pag}', function (Request $request, Response $response, array $args) {
	$controller = new RecursoController($this->view);
	return $controller->getPotencialidadesAll($request, $response, $args);
});

$app->get('/potencialidades', function (Request $request, Response $response, array $args) {
	$controller = new RecursoController($this->view);
	return $controller->getPotencialidades($request, $response, $args);
});

$app->post('/potencialidades/cadastro', function (Request $request, Response $response, array $args) {
	$controller = new RecursoController($this->view);
	return $controller->postCadastroPotencialidade($request, $response, $args);
});

$app->get('/potencialidades/cadastro[/[{id}]]', function (Request $request, Response $response, array $args) {
	$controller = new RecursoController($this->view);
	return $controller->getCadastroPotencialidade($request, $response, $args);
});

$app->get('/potencialidades/inativar/{id}', function (Request $request, Response $response, array $args) {
	$controller = new RecursoController($this->view);
	return $controller->getPotencialidadeInativar($request, $response, $args);
});

$app->get('/possibilidades/all/{pag}', function (Request $request, Response $response, array $args) {
	$controller = new RecursoController($this->view);
	return $controller->getPossibilidadesAll($request, $response, $args);
});

$app->get('/possibilidades', function (Request $request, Response $response, array $args) {
	$controller = new RecursoController($this->view);
	return $controller->getPossibilidades($request, $response, $args);
});

$app->post('/possibilidades/cadastro', function (Request $request, Response $response, array $args) {
	$controller = new RecursoController($this->view);
	return $controller->postCadastroPossibilidade($request, $response, $args);
});

$app->get('/possibilidades/cadastro[/[{id}]]', function (Request $request, Response $response, array $args) {
	$controller = new RecursoController($this->view);
	return $controller->getCadastroPossibilidade($request, $response, $args);
});

$app->get('/possibilidades/inativar/{id}', function (Request $request, Response $response, array $args) {
	$controller = new RecursoController($this->view);	
	return $controller->getPossibilidadeInativar($request, $response, $args);
});


$app->get('/iniciativas_my', function (Request $request, Response $response, array $args) {
	$controller = new RecursoController($this->view);	
	return $controller->getViewMinhasIniciativas($request, $response, $args);
});


$app->get('/iniciativas', function (Request $request, Response $response, array $args) {
	$controller = new RecursoController($this->view);	
	return $controller->getViewListaIniciativas($request, $response, $args);
});



$app->get('/recursos/nome/json', function (Request $request, Response $response, array $args) {		
	$controller = new RecursoController($this->view);
	return $controller->getDiferentesNomesDeRecursos($request, $response, $args);
});

$app->get('/mapa/recursos/{tipo}/{nome}', function (Request $request, Response $response, array $args) {
	$controller = new RecursoController($this->view);
	return $controller->getMapaRecursos($request, $response, $args);
});

$app->get('/mapa/recursos/{id}', function (Request $request, Response $response, array $args) {
	$controller = new RecursoController($this->view);
	return $controller->getMapaRecursosId($request, $response, $args);
});