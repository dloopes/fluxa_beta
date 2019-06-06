<?php
namespace Fluxa\Controller;
use Fluxa\Exception\BusinessException;
use Fluxa\Exception\ControlerException;
use Fluxa\Business\NotificacaoBusiness;

class NotificacaoController {

	private $view;

	public function __construct($view) {
		$this->view = $view;
	}	

	public function getNotificacao($request, $response, $args) {	

		$idNotificacao = $request->getAttribute('id');

		$notificacaoBusiness = new NotificacaoBusiness();

		$notificacao = $notificacaoBusiness->buscarPorId($idNotificacao);

		//Salva todas as notificações com a mesma url do mesmo usuario como visualizada
		$notificacaoBusiness->updateNotificacaoVisualizada($notificacao->getUrl());

		//$notificacao->setVisualizado(1);
		//$notificacaoBusiness->salvar($notificacao);

		return $response->withStatus(302)->withHeader('Location', $notificacao->getUrl());

	}

}