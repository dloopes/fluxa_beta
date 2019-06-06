<?php
use \Fluxa\Controller\SecurityController as SecurityController;

use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

# Start the session
session_start();

require 'vendor/autoload.php';
require 'settings.php';
//require 'vendor/google-api-php-client-2.2.0/vendor/autoload.php';

$app = new Slim\App(['settings' => ['displayErrorDetails' => true]]);

//Enable debugging (on by default)
//$app->config('debug', true);

$app->add(function (Request $request, Response $response, $next) {
	$controller = new SecurityController();
	return $controller->verificaUsuarioLogado($request, $response, $next);
});

// Get container
$container = $app->getContainer();

// Register component on container
$container['view'] = function ($container) {
	return new \Slim\Views\PhpRenderer('src/view/');
};

//Carregando as rotas
$routers = glob(__DIR__ . '/routers/*.router.php');
foreach ($routers as $router) {
	require $router;
}

$app->run();