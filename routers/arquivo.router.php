<?php

use Fluxa\Controller\ArquivoController as ArquivoController;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;


//

$app->get('/midia_teste', function (Request $request, Response $response, array $args) {
        $controller = new ArquivoController($this->view);
	return $controller->getTeste($request, $response, $args);
});
