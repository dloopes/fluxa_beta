<?php
use Fluxa\Controller\UsuarioController as UsuarioController;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

$app->get('/cadastro', function (Request $request, Response $response, array $args) {
	$controller = new UsuarioController($this->view);
	return $controller->getCadastro($request, $response, $args);
});

$app->get('/usuarios/{pag}', function (Request $request, Response $response, array $args) {
	$controller = new UsuarioController($this->view);
	return $controller->getUsuarios($request, $response, $args);
});

$app->get('/usuario/{id_usuario}[/{tab}/{pag}]', function (Request $request, Response $response, array $args) {
	$controller = new UsuarioController($this->view);
	return $controller->getUsuario($request, $response, $args);
});

$app->post('/cadastro', function (Request $request, Response $response, array $args) {
	$controller = new UsuarioController($this->view);
	return $controller->novoUsuario($request, $response, $args);
});

$app->get('/cadastro/email/{key}', function (Request $request, Response $response, array $args) {
	$controller = new UsuarioController($this->view);
	return $controller->confirmaEmail($request, $response, $args);
});

$app->get('/recuperar_senha', function (Request $request, Response $response, array $args) {
	$controller = new UsuarioController($this->view);
	return $controller->getRecuperarSenha($request, $response, $args);
});

$app->post('/recuperar_senha', function (Request $request, Response $response, array $args) {
	$controller = new UsuarioController($this->view);
	return $controller->postRecuperarSenha($request, $response, $args);
});

$app->get('/redefinir_senha/{key}', function (Request $request, Response $response, array $args) {
	$controller = new UsuarioController($this->view);
	return $controller->confirmaAlterarSenha($request, $response, $args);
});

$app->get('/redefinir_senha', function (Request $request, Response $response, array $args) {
	$controller = new UsuarioController($this->view);
	return $controller->getRedefinirSenha($request, $response, $args);
});

$app->post('/redefinir_senha', function (Request $request, Response $response, array $args) {
	$controller = new UsuarioController($this->view);
	return $controller->postRedefinirSenha($request, $response, $args);
});