<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

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
	$controller = new SecurityController(); //Testando o login e senha aqui..
	return $controller->verificaUsuarioLogado($request, $response, $next);
});

// Get container
$container = $app->getContainer();

// Register component on container
$container['view'] = function ($container) {
	return new \Slim\Views\PhpRenderer('src/view/');
};

$librares = glob(__DIR__ . '/src/library/persist/*.php');
foreach ($librares as $router) {
	require $router;
}
$librares = glob(__DIR__ . '/src/library/*.php');
foreach ($librares as $router) {
	require $router;
}

//Carregando as rotas
$routers = glob(__DIR__ . '/routers/*.router.php');
foreach ($routers as $router) {
	require $router;
}

$app->run();