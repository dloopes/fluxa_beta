<?php
namespace Fluxa\Persistence;

use \Slim\PDO\Database as PDO;

class ConexaoPDO {

	public static $instance;

	private function __construct() {

	}

	public static function getInstance() {

		if (!isset(self::$instance)) {

			self::$instance = new PDO( constant("K_PDO_CONN"), constant("K_PDO_CONN_USER"), constant("K_PDO_CONN_PASS"),
				array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
			);
                        
                        /*
                         * self::$instance = new PDO('mysql:host=213.190.6.206;port=3306;dbname=fluxa_u238694432', 'fluxa_fluxa', ''3*x!Z48+mX?F'',
				array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
			);
                         * 
                         */

			self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			self::$instance->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
		}

		return self::$instance;

	}

}

?>