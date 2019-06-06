<?php
namespace Fluxa\Exception;

use Exception;

/**
 * Classe de excecao para a camada de Business
 */
class BusinessException extends Exception {

	public function __construct($message, $code = 0, Exception $previous = null) {
		parent::__construct($message, $code, $previous);
	}

}