<?php
use Fluxa\Controller\LoginController as LoginController;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

$app->get('/login', function (Request $request, Response $response, array $args) {
	$controller = new LoginController($this->view);
	return $controller->getLogin($request, $response, $args);
});

$app->post('/login', function (Request $request, Response $response, array $args) {
	$controller = new LoginController($this->view);
	return $controller->login($request, $response, $args);
});

$app->get('/', function (Request $request, Response $response, array $args) {
	return $response->withStatus(302)->withHeader('Location', URI_SISTEMA . "login");
});

$app->get('/login/facebook', function (Request $request, Response $response, array $args) {
	$controller = new LoginController($this->view);
	return $controller->loginFacebook($request, $response, $args);
});

$app->get('/login/google', function (Request $request, Response $response, array $args) {
	$controller = new LoginController($this->view);
	return $controller->loginGoogle($request, $response, $args);
});

$app->get('/logout', function (Request $request, Response $response, array $args) {
	$controller = new LoginController($this->view);
	return $controller->getLogout($request, $response, $args);
});