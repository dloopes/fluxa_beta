 
 function  msgValidaEndereco(form){

        var res = []

        if ( form.tipo_pais == "Brasil"){
            
            if ( form.logradouro == ""){
                res.push( {"msg": "Informe o logradouro!"} );
            }
            
            if ( form.id_estado == null){
                res.push( {"msg": "Selecione o estado"} );
            }
            if ( form.id_cidade == null){
                res.push( {"msg": "Selecione o município"} );
            }
            if ( form.numero == ""){
                res.push( {"msg": "Informe o Número"} );
            }
            if ( form.bairro == ""){
                res.push( {"msg": "Informe o Bairro"} );
            }
            if ( form.cep == ""){
                res.push( {"msg": "Informe o CEP"} );
            }
        } else {

               
            if ( form.logradouro == ""){
                res.push( {"msg": "Informe o endereço!"} );
            }

            if ( form.numero == ""){
                res.push( {"msg": "Informe o Número"} );
            }


        }

        return res;

    }
