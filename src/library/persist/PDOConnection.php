<?php
namespace library\persist;
use library\persist\IDbPersist;
use Fluxa\Persistence\ConexaoPDO;

class PDOConnection implements IDbPersist{ 

       function describleTable($name_table){
	   
	   
              $sql = "SHOW /*!32332 FULL */ COLUMNS FROM `".$name_table."` ;";
			  
			  $mount = $this->fetchData( $sql );
	   
	          $saida = array();
			  
			  for ( $i = 0; $i < count($mount); $i++){
			  
			        $key =  $mount[$i]["Field"];
				  
			        $saida[ $key  ] = "";
			  }
			  
			  return $saida;
	   
	   }
	   
	   
	   function getConnection(){
	   
	         return ConexaoPDO::getInstance();	   
	   }
	   
	   function disconnect(){

	   
	   }
           
           function connect(){

	   
	         return ConexaoPDO::getInstance();
	   }
	   
	   function executeCommand($sql){
	    
		   $conn = $this->getConnection();
		   $conn->exec($sql);

	   }
	   
	   function fetchData($sql){
	   
		   $conn = $this->getConnection();
		  // print_r( $conn ); die(" ");
		  // $arr =  $conn->prepare($sql)->fetchAll();
		   $arr =  $conn->query($sql)->fetchAll();
           //print_r( $arr ); die(" ");

		   	if ( !$arr && !is_array($arr)){
                                                echo("<xmp>");
                                                  var_dump(debug_backtrace());
                                                  echo("</xmp>");  
                                                echo("<br> ERRO querie: ". $sql );
		    }
	        
			return $arr;
	   
	   }
	   
	   function formatField($field){
	   
	      return "`". trim( $field )."`";
	   }

}