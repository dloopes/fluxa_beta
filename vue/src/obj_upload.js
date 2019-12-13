
var obj_upload = {

				uploadImagem: function (files, type, objvue){

				       	    console.log("estou obj_upload ");
				       	   // console.log(files );


				       	     if ( files.length <= 0 )
                   	    	        return;


                   	            var data = new FormData();
                   	            data.append("type", type);
				                
				                for (var x = 0; x < files.length; x++) {
				                    data.append("file" + x, files[x]);
				                }

				               data.append("file_qtde", files.length.toString() ); 
                            
                               var url =  window.URL_API +"loja/lojabanner/upload"; 

				       	    console.log("URL para upload " + url );

						            $.ajax({
						                    type: "POST",
						                    url: url,
						                    contentType: false,
						                    processData: false,
						                    data: data,
						                    success: function (retorno) {

						                    	console.log("Sucesso. Tenho objVue?");
						                    	console.log(objvue);

						                        if (objvue != null && objvue.onReturnUpload != null && objvue.onReturnUpload != undefined ){
						                        	objvue.onReturnUpload(retorno, type);
						                        }
						                       
						                    },
						                    error: function (xhr, status, p3, p4) {
						                                    var err = "Error " + " " + status + " " + p3 + " " + p4;
						                                    if (xhr.responseText && xhr.responseText[0] == "{")
						                                        err = JSON.parse(xhr.responseText).Message;

						                                    console.log("Houve um erro dentro do upload: "); console.log(err );
                
						                      }
						                   }).fail(function (response) {


						                                    console.log("Houve um erro dentro do upload: "); 

						                                    console.log(url );
						                                    console.log(response );

						                  });



                   
				},
				getTitulo: function (b_type ){
					      if ( b_type == "principal")
					              return "Banner Rotativo";


					            if ( b_type == "btopo")
					              return "Banner de Topo";


					            if ( b_type == "bparc")
					              return "Banner de Parceiros";

					          return "Banner";

				},
				update_banner: function (self, tp ){

                var url =  window.URL_API +"midia/banner"; console.log("url: " + url );
                var method = "POST";

                if (self.id != null &&  self.id != ""){
                       method = "PUT"; url =  url + "/"+ self.id;
                }

                 var data = {title: self.title, alt: self.alt, abrir_como: self.abrir_como,
                 	url_abrir: self.url_abrir}

                   console.log("data sendo enviada: "); console.log(data);


                      $.ajax({
                              type: method,
                              url: url,
                              contentType: "application/x-www-form-urlencoded",
                              processData: true,
                              data: data,
                              success: function (retorno) {

                              	 if ( self.returnSave != null ){
                                        self.returnSave(retorno, tp)
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
                          });

                },
				delete_imagem: function(id, objvue ){



                               var url =  window.URL_API +"midia/"+ id ; 


						            $.ajax({
						                    type: "DELETE",
						                    url: url,
						                    contentType: false,
						                    processData: false,
						                    data: {},
						                    success: function (retorno) {

						                        if (objvue != null && objvue.onReturnDeleteUpload != null 
						                        	      && objvue.onReturnDeleteUpload != undefined ){
						                        	objvue.onReturnDeleteUpload(retorno);
						                        }
						                       
						                    },
						                    error: function (xhr, status, p3, p4) {
						                                    var err = "Error " + " " + status + " " + p3 + " " + p4;
						                                    if (xhr.responseText && xhr.responseText[0] == "{")
						                                        err = JSON.parse(xhr.responseText).Message;

						                                    console.log("Houve um erro: "); console.log(err );
                
						                      }
						                   }).fail(function (response) {


						                                    console.log("Houve um erro: "); 

						                                    console.log(url );
						                                    console.log(response );

						                  });


				}




} 



window.obj_upload = obj_upload;
