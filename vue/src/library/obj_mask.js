var obj_mask = {
    

                //valida numero inteiro com mascara
                mascaraInteiro: function (str, event){

                    if ( event == null )
                       event = window.event;

                    if ( event == null)
                         return true;


                    Tecla = event.which;

                    if(Tecla == null)
                            Tecla = event.keyCode;


                    if ( Tecla == 8 || Tecla == 0 )
                        return true;

                        if ( Tecla < 48 || Tecla > 57){
                                event.returnValue = false;
                                return false;
                        }
                        return true;
                },




                Numerico: function (event,code) /*aceita numeros, ponto e virgula*/
                {
                    Tecla = event.which;
                       if(Tecla == null)
                        Tecla = event.keyCode;


                    if ( Tecla == 8 || Tecla == 0 )
                        return true;

                        if((Tecla > 47 && Tecla <= 57)||((code==2)&&(Tecla==47))||
                        ((Tecla==44)||(Tecla==46)) || ( ( Tecla==45) ) ) {
                                return true;
                                }
                        else{
                                return false;
                                }
                    return true;
                },


                 date_show: function (value) {
                  if (!value) return ''
                  if (value.indexOf("-") <= 0 ) return value;

                  value = value.toString();

                  var ar = value.split(' ');
                  var pedaco_data = ar[0].split('-');

                  var data_saida = pedaco_data[2] + "/"+ pedaco_data[1] +"/" + pedaco_data[0];

                   return data_saida;
                },

    

            //adiciona mascara ao telefone
            MascaraTelefone: function(tel, event){  
                    if( this.mascaraInteiro(tel, event)==false){
                            event.returnValue = false;
                            return false;
                    }     
                    if ( tel.value.length > 14 ){
                           
                          return this.formataCampo(tel, '(00) 00000-0000', event);
                    }else{
                        
                          return this.formataCampo(tel, '(00) 0000-0000', event);
                    }
            },
            
            MascaraCNPJ: function (cnpj, event){
                    if(this.mascaraInteiro(cnpj, event)==false){
                            event.returnValue = false;
                    }       
                    return this.formataCampo(cnpj, '00.000.000/0000-00', event);
            },
            
            
                        //adiciona mascara de data
            MascaraData: function (event, data){
                    if(this.mascaraInteiro(data, event)==false){
                            event.returnValue = false;
                    }       
                    return this.formataCampo(data, '00/00/0000', event);
            },

            mascaraData: function (event, data){

                    if(this.mascaraInteiro(data)==false){
                            event.returnValue = false;
                    }       
                    return this.formataCampo(data, '00/00/0000', event);

            },
            
            dataBanco: function (value){
                if (! value )
                    return '';
                
                
                var ar = value.split('/');
                if ( ar.length > 1){
                    return ar[2]+"-"+ar[1]+"-"+ar[0];
                }
                return value;
            },
            

            replaceTotal: function (texto,strI,strF){
                    var tam, vet, i;
                    vet = texto.split(strI);
                    tam = vet.length;
                    for(i=0;i<tam;i++){
                            texto = texto.replace(strI,strF);
                    }
                    return texto;
            },
            


           getNumBr: function (tx)
           {
                    var totalH = 0;
                    //var stx = replaceTotal( tx , ".",",");

                    var stx = parseFloat( obj_mask.replaceTotal( tx , ",","."));

                           if ( stx.toString() != "NaN")
                                 totalH += stx;

                    // stx = obj_mask.replaceTotal( totalH.toString() , ".",",");


                     return     stx;  
            },
            

            //formata de forma generica os campos
            formataCampo: function(campo, Mascara, evento) { 
                    var boleanoMascara; 

                    if ( evento == null )
                       evento = window.event;

                    Tecla = evento.which;

                    if(Tecla == null)
                           Tecla = evento.keyCode;

                        if ( Tecla == 8 || Tecla == 0 )
                            return true;

                           /// alert( Tecla );   


                    var Digitato = Tecla;
                    exp = /\-|\.|\:|\/|\(|\)| /g
                    campoSoNumeros = campo.value.toString().replace( exp, "" ); 

                    var posicaoCampo = 0;    
                    var NovoValorCampo="";
                    var TamanhoMascara = campoSoNumeros.length;; 

                    if (Digitato != 8) { // backspace 
                            for(i=0; i<= TamanhoMascara; i++) { 
                                    boleanoMascara  = (  (Mascara.charAt(i) == ":") || (Mascara.charAt(i) == "-") || (Mascara.charAt(i) == ".")
                                                                            || (Mascara.charAt(i) == "/")) 
                                    boleanoMascara  = boleanoMascara || ((Mascara.charAt(i) == "(") 
                                                                            || (Mascara.charAt(i) == ")") || (Mascara.charAt(i) == " ")) 
                                    if (boleanoMascara) { 
                                            NovoValorCampo += Mascara.charAt(i); 
                                              TamanhoMascara++;
                                    }else { 
                                            NovoValorCampo += campoSoNumeros.charAt(posicaoCampo); 
                                            posicaoCampo++; 
                                      }              
                              }      
                            campo.value = NovoValorCampo;
                              return true; 
                    }else { 
                            return true; 
                    }
            },

            show_number:  function (value) {
 
                    return parseFloat((value).toFixed(2)).toLocaleString();
            }

    
    
    
}

window.obj_mask = obj_mask;