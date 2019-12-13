<?php

//define("URI_SISTEMA", "https://" . $_SERVER['SERVER_NAME'] . "/sistema/");
/* define("URI_SISTEMA", "http://" . $_SERVER['SERVER_NAME'] . ":8080/diogo_loopes/fluxa_beta/");
define("BASE_SISTEMA", "/diogo_loopes/fluxa_beta/");
define("URL_API", "/diogo_loopes/fluxa_beta/api/");
*/
define("URI_SISTEMA", "http://" . $_SERVER['SERVER_NAME'] . ":8087/");
define("BASE_SISTEMA", "/");
define("URL_API", "/api/");

define("KEY_PASS", "flux@.b3ta"); //key pass pra ajudar na autenticação da api.

$g_ambiente = "dev"; //prod

$g_asset_version = "100";

if ( $g_ambiente == "dev"){
	$g_asset_version =time();
}

define("K_ASSET", $g_asset_version  );
/* --------------------- CONSTANTES PARA CONFIGURAÇÃO DE TELA -------------------------------- */

/* Define a quantidade de registros que aparecem nas tabelas de consulta */
define("QDE_REG_PAG", 20);

/* Define a quantidade de botões na paginação */
define("QDE_BTN_PAG", 6); 

define("K_PATH_FILES", "F:\\OpenServers\\apache_php5\\www\\diogo_loopes\\files");
define("BASE_URL_ANEXO", "/diogo_loopes/files/");
define("BASE_THUMB_PROCESS","/diogo_loopes/fluxa_beta/thumb/thumb.php");

/* ------------------------------------------------------------------------------------------- */