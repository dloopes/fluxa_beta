var obj_api = {
	

        call_delete: function(tipo, id, fn_return ){


                var url =  window.URL_API +  tipo +"/"+id; 

                 $.ajax({
                              type: "DELETE",
                              url: url,
                              contentType: false, //"application/x-www-form-urlencoded",
                              processData: false,
                              headers: {
                                    'Authorization':window.K_AUTHORIZATION,
                                   // 'Content-Type':'application/json'
                              },
                              success: function (retorno) {
                                  
                                  console.log(retorno);
                                 
                                   if (fn_return != null ){
                                      	fn_return(retorno, tipo)
                                   }

                                 
                              },
                              error: function (xhr, status, p3, p4) {
                                  var err = "Error " + " " + status + " " + p3 + " " + p4;
                                  if (xhr.responseText && xhr.responseText[0] == "{")
                                      err = JSON.parse(xhr.responseText).Message;


                                  console.error(err);

                              }
                          }).fail(function (response) {
                                console.log("Falha ao tentar obter dados");
                                console.log(response);   
                                
                                $("#div_error_api").html( response.responseText );
                          });


      },
      get_url(tipo){
          return window.URL_API +  tipo;

      },
      call: function(tipo, method, data , fn_return ){


                var url =  window.URL_API +  tipo; 

                if ( (method == "get" || method =="GET") && data != null ){
                    var comp = this.serialize(data);
                    if ( comp != ""){
                        url += "?"+ comp;

                    }
                }

                console.log( url );

                 $.ajax({
                              type: method,
                              url: url,
                              contentType: false, //"application/x-www-form-urlencoded",
                              processData: false,
                              data: this.getFormData(data),
                              headers: {
                                    'Authorization':window.K_AUTHORIZATION,
                                    //'Content-Type':'application/json'
                              },
                              success: function (retorno) {
                                 
                                   if (fn_return != null ){

                                        try{

                                            var obj = JSON.parse( retorno);
                                            fn_return( obj, tipo);

                                        }catch(exp){
                                            console.log("não consegui fazer json");

                                            $("#div_error_api").html( "não consegui gerar json <br>" + retorno );
                                            console.log( "exceção?",  exp );
                                            
                                        }
                                   }

                                 
                              },
                              error: function (xhr, status, p3, p4) {
                                  var err = "Error " + " " + status + " " + p3 + " " + p4;
                                  if (xhr.responseText && xhr.responseText[0] == "{")
                                      err = JSON.parse(xhr.responseText).Message;


                                  console.error(err);

                              }
                          }).fail(function (response) {
                                console.log("Falha ao tentar obter dados");
                                console.log(response);   

                                $("#div_error_api").html( response.responseText );
                          });


     },

     getBase64(file) {
        return new Promise((resolve, reject) => {
          const reader = new FileReader();
          console.log("file lido?", file );
          reader.readAsDataURL(file);
          reader.onload = () => resolve({base: reader.result, name: file.name} );
          reader.onerror = error => reject(error);
        });
      },
     getFormData(obj){
         
        var data = new FormData();
        for (var p in obj){
                        if (obj.hasOwnProperty(p) && obj[p] != null ) {
                           // str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
                           data.append(p, obj[p] );
                        }
          }

          return data;
     },

    serialize (obj ){

                var str = [];
                for (var p in obj)
                if (obj.hasOwnProperty(p) && obj[p] != null ) {
                    str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
                }
                return str.join("&");


       }



}

window.obj_api = obj_api;