<?php
namespace Fluxa\Persistence;

use \Slim\PDO\Database as PDO;

class ConexaoPDO {

	public static $instance;

	private function __construct() {

	}

	public static function getInstance() {

		if (!isset(self::$instance)) {

			self::$instance = new PDO('mysql:host=rafaeldatabase;port=3305;dbname=dloopes_fluxa', 'root', '',
				array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
			);

			self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			self::$instance->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
		}

		return self::$instance;

	}

}

?>