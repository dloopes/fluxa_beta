<?php
use Fluxa\Controller\RecursoController as RecursoController;
use Fluxa\Controller\ArquivoController as ArquivoController;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;
use Fluxa\Controller\FluxoController as FluxoController;

// Recursos -------------------
$app->get('/api/recursos_new', function (Request $request, Response $response, array $args) {
	$controller = new RecursoController($this->view);	
	return $controller->api_new($request, $response, $args);
});
$app->get('/api/recursos', function (Request $request, Response $response, array $args) {
	$controller = new RecursoController($this->view);	
	return $controller->api_index($request, $response, $args);
});
$app->get('/api/recursos/{id}', function (Request $request, Response $response, array $args) {
	$controller = new RecursoController($this->view);	
	return $controller->api_show($request, $response, $args);
});
$app->post('/api/recursos', function (Request $request, Response $response, array $args) {
	$controller = new RecursoController($this->view);	
	return $controller->api_store($request, $response, $args);
});
$app->post('/api/recursos_edit/{id}', function (Request $request, Response $response, array $args) {
	$controller = new RecursoController($this->view);	
	return $controller->api_edit($request, $response, $args);
});
$app->delete('/api/recursos/{id}', function (Request $request, Response $response, array $args) {
	$controller = new RecursoController($this->view);	
	return $controller->api_delete($request, $response, $args);
});

$app->get('/api/recurso_associacao_grid', function (Request $request, Response $response, array $args) {
	$controller = new RecursoController($this->view);	
	return $controller->api_index_associacao($request, $response, $args);
});

$app->get('/api/recursos_busca', function (Request $request, Response $response, array $args) {
	$controller = new RecursoController($this->view);	
	return $controller->api_busca($request, $response, $args);
});

$app->post('/api/recurso_associacao_grid', function (Request $request, Response $response, array $args) {
	$controller = new RecursoController($this->view);	
	return $controller->api_add_associacao($request, $response, $args);
});
$app->delete('/api/recurso_associacao_grid/{id}', function (Request $request, Response $response, array $args) {
	$controller = new RecursoController($this->view);	
	return $controller->api_remove_associacao($request, $response, $args);
});


// Arquivos ---------------------------
$app->post('/api/arquivo', function (Request $request, Response $response, array $args) {
    $controller = new ArquivoController($this->view);
   return $controller->upload($request, $response, $args);
});
$app->post('/api/midia', function (Request $request, Response $response, array $args) {
    $controller = new ArquivoController($this->view);
   return $controller->upload($request, $response, $args);
});

$app->get('/api/arquivo2', function (Request $request, Response $response, array $args) {
      $controller = new ArquivoController();
      // $response->write("teste?"); die(" ");
      return $controller->upload($request, $response, $args);
});
$app->get('/api/arquivo', function (Request $request, Response $response, array $args) {
      $controller = new ArquivoController();
      // $response->write("teste?"); die(" ");
      return $controller->index($request, $response, $args);
});


$app->get('/api/midia', function (Request $request, Response $response, array $args) {
      $controller = new ArquivoController();
      // $response->write("teste?"); die(" ");
      return $controller->index($request, $response, $args);
});

$app->delete('/api/midia/{id}', function (Request $request, Response $response, array $args) {
      $controller = new ArquivoController();
      // $response->write("teste?"); die(" ");
      return $controller->destroy($request, $response, $args);
});

//-------------------------------


//Fluxo -----------------------
$app->post('/api/fluxo[/]', function (Request $request, Response $response, array $args) {
	$controller = new FluxoController($this->view);
	return $controller->postFluxo($request, $response, $args);
});
$app->get('/api/fluxo_list', function (Request $request, Response $response, array $args) {
	$controller = new FluxoController($this->view);
	return $controller->api_lista($request, $response, $args);
});



//Fluxo ----------------------

//Recurso Cadastros 
$app->post('/api/recurso_cadastros[/]', function (Request $request, Response $response, array $args) {
	$controller = new \Fluxa\Controller\RecursoCadastroController($this->view);
	return $controller->salvargrid($request, $response, $args);
});

$app->get('/api/recurso_cadastros[/]', function (Request $request, Response $response, array $args) {
      $controller = new \Fluxa\Controller\RecursoCadastroController($this->view);
      return $controller->listgrid($request, $response, $args);
});



?>