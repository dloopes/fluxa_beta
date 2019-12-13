<?php
namespace Fluxa\Controller;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\UploadedFile;
use library\persist\connAccess;
use library\persist\PDOConnection;


class BaseController {
    
    function sendError($response, $msg){
        $arr = array("msg"=>$msg, "erro" => 1 );
    	$response->withHeader('Content-Type', 'application/json');
        //header('Content-Type: application/json');
        return json_encode($arr);
    }
    

    function sendResponse($response, $arr){
    	$response->withHeader('Content-Type', 'application/json');
    	//header('Content-Type: application/json');
    	return json_encode($arr);
    }
    
    
}
