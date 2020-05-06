<?php
namespace library; 

 //Tem como objetivo fazer chamadas a api2 da mesma forma que é feito via javascript.
 //Como o PHP não tem o THEN, então o retorno da chamada virá como texto, sendo um retorno do método Call.
 class Api2
 {
     public static function Call($endpoint, $method, $data){
         
         $curl = curl_init();
         $url = URL_API2_COMPLETE . $endpoint;
         curl_setopt($curl, CURLOPT_URL, $url);
         
         //print_r( $data  );
         
         
                        switch (strtoupper($method) )
                        {
                            case "POST":
                                curl_setopt($curl, CURLOPT_POST, 1);

                                if ($data){
                                    curl_setopt($curl, CURLOPT_POSTFIELDS,  json_encode( $data) );
                                    //echo("dei o curdata.. ");
                                }
                                break;
                            case "PUT":
                                curl_setopt($curl, CURLOPT_PUT, 1);
                                break;
                            default:
                                if ($data)
                                    $url = sprintf("%s?%s", $url, http_build_query($data));
                        }

                        // Optional Authentication:
                        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                        
                        $authorization = \Fluxa\Business\UsuarioBusiness::getAuthorizationKey(\Fluxa\Business\UsuarioBusiness::getSessionIDUsuario());
                        
                         curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                                    'Authorization: ' . $authorization,
                                    'Content-Type: application/json',
                                 ));
                        
                        //curl_setopt($curl, CURLOPT_USERPWD, "username:password");

                        curl_setopt($curl, CURLOPT_URL, $url);
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

                        $result = curl_exec($curl);
                        
                        if ( $result === false ){
                            return curl_error($curl);
                        }

                        curl_close($curl);

                        return $result;

     }
     
     
 }
