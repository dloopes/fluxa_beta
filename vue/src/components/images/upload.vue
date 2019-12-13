<template>
 <div>
   <div  v-bind:class="getClassName('col-lg-12')"  >
			   <div v-bind:class="getClassName('box')">
			   <div v-bind:class="getClassName('box-body')">
                <div id="div_drag" v-bind:style="getStyleDrop()">
                         {{getMsgInicial()}}
                </div>         
                    
                <div class="form-group">
                	<table>
                     <tr>
                            <td>
                            	<label for="file_uploads"> Arquivos </label>
                           <input type="file" name="file_uploads" value="Selecionar arquivos"
                            multiple="multiple" class="form-control"
                            id="file_uploads" @change="onFileChange" >
                            </td>
                            <td valign="bottom" style="text-align: right;">

                            <button class="btn btn-secondary"  v-on:click="convertToEncode64" >
                              <span v-html="textUpload"></span></button>
                            </td>
                     </tr>
                	</table>
                	

                </div>

			   </div>
			</div>
   </div>
</div>

</template>

<script>
    export default {
        props: ['onSave', 'ptype' , 'p_parentid', 'show_drop','msg_tamanho'],

        data: function() {
            return {

              action: "list",
            	items: [],
                id: "",
                files: [],
                files_input: [],

                disable_button: false,
                textUpload: "Upload",
                qtde_encode_64 : 0,
                qtde_files_total: 0,
                files_to_send: []
            }
        },
        methods:{

        	       getMsgInicial(){
        	       	let msg = "";
        	       	
        	        if (  this.msg_tamanho != null && this.msg_tamanho != undefined ){
        	          	console.log("MSG TAMANHO: " + this.msg_tamanho );
        	        	msg = this.msg_tamanho;
        	        }	 
                        return  "ARRASTE ARQUIVOS AQUI " + msg;
        	       },
        	       getClassName(typ){
                           if ( this.show_drop != null && this.show_drop != undefined && this.show_drop == "0" ){
                          	  return "";
                          }
                          return typ;
        	       },

        	       getStyleDrop(){
                          if ( this.show_drop != null && this.show_drop != undefined && this.show_drop == "0" ){
                          	  return "display:none";
                          }
                          return "";
        	       },
                   upload(files){

                   	   this.files = files;

		                   	if ( files.length == 1){
							    //alert('Upload '+files.length+' File(s).');
							    console.log(files[0]);
							    $('#div_drag').html(files[0].name );
		                   	}else if ( files.length > 1 && files.length <= 10){

                                var str = "";
		                   		for ( var i = 0; i < files.length; i++){
		                   			if ( str != "")
		                   				str += ", ";

                                     str += files[i].name;


							         $('#div_drag').html(str );
		                   		}

		                   	}else if ( files.length > 10 ){
							    $('#div_drag').html(files.length.toString() +" arquivo(s) " );
		                   	}else{
		                   		 $('#div_drag').html(this.getMsgInicial() );
		                   	}
                   },

                   convertToEncode64(){

                   	var self = this;

                   	this.qtde_files_total =  this.files.length+ this.files_input.length;

                   	 for (var x = 0; x < this.files.length; x++) {
                   	 	obj_api.getBase64( this.files[x] ).then(function(resultado){

                   	 		self.files_to_send.push( resultado );
                   	 		self.qtde_encode_64++;

                   	 		if ( self.qtde_encode_64 >= self.qtde_files_total ){
                   	 			self.sendUpload2();


                   	 		}

                   	 	});
					 }
	                 for (var x = 0; x < this.files_input.length; x++) {


	                 	 	           obj_api.getBase64( this.files_input[x] ).then(function(resultado){

					                   	 		self.files_to_send.push( resultado );
					                   	 		self.qtde_encode_64++;

					                   	 		if ( self.qtde_encode_64 >= self.qtde_files_total ){
                   	 			                              self.sendUpload2();

					                   	 		}

					                   	 	});
	                }



                   },

                   sendUpload2(){

	                   	    if ( this.files.length <= 0  && this.files_input.length <= 0 )
	                   	    	return;


	                   	            var data = new FormData();
	                   	            var qtde = 0;
					                for (var x = 0; x < this.files_to_send.length; x++) {
					                    data.append("file" + x, this.files_to_send[x].base);
					                    data.append("file" + x+"_name", this.files_to_send[x].name);
					                    qtde++;
					                }

					                let p_type = "midia";

					                if ( this.ptype != null && this.ptype != undefined ){
					                	p_type = this.ptype;
					                }

	                                this.disable_button = true;
					                this.textUpload = "Enviando..";

					                var file_qtde = this.files.length + this.files_input.length;

					               data.append("file_qtde", file_qtde.toString() ); 
					               data.append("type_image", p_type );  
					               data.append("tipo", p_type ); 

					               if ( this.p_parentid != null && this.p_parentid != undefined ){

					                       data.append("parent_id", this.p_parentid.toString() ); 
					               }
	                            
	                               let self = this;
	                               var url =  window.URL_API +"arquivo"; 
	                               console.log("enviando upload: " + url );


							            $.ajax({
							                    type: "POST",
							                    url: url,
                                                cache: false,
							                    contentType: false,
							                    processData: false,
							                    data: data,
							                    headers: {
					                                    'Authorization':window.K_AUTHORIZATION,
					                                    //'Content-Type':'application/json'
					                             },
							                    xhr: function(){
											          var xhr = new window.XMLHttpRequest();
											          //Upload progress, request sending to server
											          xhr.upload.addEventListener("progress", function(evt){
											            //console.log("in Upload progress");
											            //console.log("Upload Done");
											              self.progress(evt);
											          }, false);
											          //Download progress, waiting for response from server
											          xhr.addEventListener("progress", function(e){
											               self.progress(e);
											          }, false);
											          return xhr;
											    },
							                    success: function (retorno) {

							                        if ( self.onSave != null && self.onSave != undefined ){
							                        	self.onSave(retorno, 'upload');
							                        }


			        	                              self.disable_button = false;
			        	                              self.textUpload = "Upload";

			        	                              if ( self.files_input != null ){
                                                          //self.files_input.splice(0, self.files_input.length);

                                                         self.files_input  = [];
			        	                              }
			        	                           

			        	                              if ( self.files != null && self.files != undefined){

			        	                                  //self.files.splice(0, self.files.length);
			        	                                  self.files = [];
													  }
													  
			        	                              if ( self.files_to_send != null && self.files_to_send != undefined){

			        	                                  self.files_to_send = [];
													  }
													  
													  

		                   		                      $('#div_drag').html("ARRASTE ARQUIVOS AQUI");

                                                                                   $("#file_uploads").val("");
							                       
							                    },
							                                error: function (xhr, status, p3, p4) {
							                                    var err = "Error " + " " + status + " " + p3 + " " + p4;
							                                    if (xhr.responseText && xhr.responseText[0] == "{")
							                                        err = JSON.parse(xhr.responseText).Message;


							                                    //document.getElementById("span_title_file").innerHTML = old_text;
							                                   
							                                }
							                            }).fail(function (response) {

							                            	console.log(response);

							                            	obj_alert.show("Erro na API: ",
							                            		   "Erro ao tentar enviar", "error");
                                                                                                   
                                                                                                   
                                                                                        $("#div_error_api").html( response.responseText );

           


							                            });



	         },






	                sendUpload(){

	                   	    if ( this.files.length <= 0  && this.files_input.length <= 0 )
	                   	    	return;


	                   	            var data = new FormData();
	                   	            var qtde = 0;
					                for (var x = 0; x < this.files.length; x++) {
					                    data.append("file" + x, this.files[x]);
					                    console.log("adicionando arquivo " , this.files[x]);
					                    qtde++;
					                }
					                 for (var x = 0; x < this.files_input.length; x++) {
					                    data.append("file" + qtde, this.files_input[x]);
					                    console.log("adicionando arquivo " , this.files_input[x]);
					                    qtde++;
					                }

					                let p_type = "midia";

					                if ( this.ptype != null && this.ptype != undefined ){
					                	p_type = this.ptype;
					                }

	                                this.disable_button = true;
					                this.textUpload = "Enviando..";

					                var file_qtde = this.files.length + this.files_input.length;

					               data.append("file_qtde", file_qtde.toString() ); 
					               data.append("type_image", p_type );  
					               data.append("tipo", p_type ); 

					               if ( this.p_parentid != null && this.p_parentid != undefined ){

					                       data.append("parent_id", this.p_parentid.toString() ); 
					               }
	                            
	                               let self = this;
	                               var url =  window.URL_API +"arquivo"; 
	                               console.log("enviando upload: " + url );


							            $.ajax({
							                    type: "POST",
							                    url: url,
                                                cache: false,
							                    contentType: "multipart/form-data", //false,
							                    processData: true, //false
							                    data: data,
							                    headers: {
					                                    'Authorization':window.K_AUTHORIZATION,
					                                    //'Content-Type':'application/json'
					                             },
							                    xhr: function(){
											          var xhr = new window.XMLHttpRequest();
											          //Upload progress, request sending to server
											          xhr.upload.addEventListener("progress", function(evt){
											            //console.log("in Upload progress");
											            //console.log("Upload Done");
											              self.progress(evt);
											          }, false);
											          //Download progress, waiting for response from server
											          xhr.addEventListener("progress", function(e){
											               self.progress(e);
											          }, false);
											          return xhr;
											    },
							                    success: function (retorno) {

							                        if ( self.onSave != null && self.onSave != undefined ){
							                        	self.onSave(retorno, 'upload');
							                        }


			        	                              self.disable_button = false;
			        	                              self.textUpload = "Upload";

			        	                              if ( self.files_input != null ){
                                                          //self.files_input.splice(0, self.files_input.length);

                                                         self.files_input  = [];
			        	                              }
			        	                           

			        	                              if ( self.files != null && self.files != undefined){

			        	                                  //self.files.splice(0, self.files.length);
			        	                                  self.files = [];
			        	                              }

		                   		                      $('#div_drag').html("ARRASTE ARQUIVOS AQUI");

                                                                                   $("#file_uploads").val("");
							                       
							                    },
							                                error: function (xhr, status, p3, p4) {
							                                    var err = "Error " + " " + status + " " + p3 + " " + p4;
							                                    if (xhr.responseText && xhr.responseText[0] == "{")
							                                        err = JSON.parse(xhr.responseText).Message;


							                                    //document.getElementById("span_title_file").innerHTML = old_text;
							                                   
							                                }
							                            }).fail(function (response) {

							                            	console.log(response);

							                            	obj_alert.show("Erro na API: ",
							                            		   "Erro ao tentar enviar", "error");
                                                                                                   
                                                                                                   
                                                                                        $("#div_error_api").html( response.responseText );

           


							                            });



	         },

		        onFileChange(e) {
				  var files = e.target.files || e.dataTransfer.files;
				  if (!files.length)
				    return;

				   this.files_input.splice(0, this.files_input.length);

				   for ( var i = 0; i < files.length; i++){
				   	       this.files_input.push( files[i]);
				   }

				  //this.createImage(files[0]);
				},


				progress (e){

				    if(e.lengthComputable){
				        var max = e.total;
				        var current = e.loaded;

				        var Percentage = (current * 100)/max;
				        console.log(Percentage);

		                 this.textUpload = Percentage.toString() + "% enviado.";
				        if(Percentage >= 100)
				        {
				        	 this.textUpload = "Envio concluído. Salvando imagens..";
				           // process completed  
				        }
				    }  
				 },

		        setFilesInput( obj ){
		                    let files = obj.files;

		                    this.files_input = files;         
		        } 
        },

        mounted() {

        	let self = this;

					$('#div_drag').on(
					    'dragover',
					    function(e) {
					        e.preventDefault();
					        e.stopPropagation();
					    }
					)
					$('#div_drag').on(
					    'dragenter',
					    function(e) {
					        e.preventDefault();
					        e.stopPropagation();
					    }
					)
					$('#div_drag').on(
					    'drop',
					    function(e){
					        if(e.originalEvent.dataTransfer){
					            if(e.originalEvent.dataTransfer.files.length) {
					                e.preventDefault();
					                e.stopPropagation();
					                /*UPLOAD FILES HERE*/
					                self.upload(e.originalEvent.dataTransfer.files);
					            }   
					        }
					    }
					);
					

        }
   

}


 </script>       
