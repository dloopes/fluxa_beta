<?php
use Fluxa\Controller\NotificacaoController as NotificacaoController;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

$app->get('/notificacao/{id}', function (Request $request, Response $response, array $args) {
	$controller = new NotificacaoController($this->view);
	return $controller->getNotificacao($request, $response, $args);
});