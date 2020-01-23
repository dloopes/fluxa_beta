<?php
namespace library; 

 class PaginationService
 {

      public static function get_limit_sql( $inicio, $pagesize ){
        return " limit ". $inicio.", ". $pagesize;
      }
      
      
      
       public static function SetaRsetPaginacao($selQtdeRegistro, $selPagina,$totalRegistro, &$inicio, &$fim)

        {

                $pageCount =  ($totalRegistro / $selQtdeRegistro);
                
                if ($pageCount < 1)
                        $pageCount = 1; 

                if ($pageCount > round($pageCount))
                        {    $pageCount++;}
                else 
                        {  $pageCount = round($pageCount); }

                $pageCount = (int)$pageCount;


                if ( $selPagina > (int)$pageCount){
                        $selPagina = (int)$pageCount;
                    
                }
                
             $inicio = $selQtdeRegistro * ($selPagina -1);
             $fim = $inicio + $selQtdeRegistro;

             if ($fim > $totalRegistro){
                 $fim = $totalRegistro;
                 
             }
                 return $inicio."_".$fim;

         }
         
         
          public static  function TotalPaginasPaginacao($totalRegistro, $selQtdeRegistro){


			  $pageCount = ($totalRegistro / $selQtdeRegistro);

			  if ($pageCount < 1)
				 $pageCount = 1; 			  

			  if ($pageCount > round($pageCount))

			  {    $pageCount++;}

			  else 

			  {  $pageCount = round($pageCount); }

			  $pageCount = (int)$pageCount;	
			
			  return $pageCount;			
	
         }

    
     
     
 
 }
