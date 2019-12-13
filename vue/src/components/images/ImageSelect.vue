<template>
	<div>

     <section class="content-header">

                    <section class="col-lg-12">
                    	<table style="width: 99%">
                                <tr>
                                	<td>
 <h1>
                          Mídia

                          </h1>
                          <ol class="breadcrumb" style="display: none">
                            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                            <li><a href="#">Forms</a></li>
                            <li class="active">General Elements</li>
                          </ol>
                                	</td>
                                	<td>
  <div class="pull-right">
                            <a href="#" v-if="botao_voltar_visible"  v-on:click="botao_voltar">
                               <i class="fa fa-arrow-left"></i> Voltar para biblioteca de mídia
                            </a> 
                            </div>
                                	</td>
                           
                                	</tr>                    	
                                </table>
                         
                        </section>
                         
          </section>
            <div class="col-lg-12">
			   <div class="box">
			   <div class="box-body">
                         
                       <img id="image_details" v-bind:src="url" style="max-height: 530px; max-width: 96%" >
			   </div>
			   <div class="box-footer">
                            <div class="form-group">
                                  <label for="image_alt">Selecionar Tamanho: </label>

                                  <select name="sel_tamanho" id="sel_tamanho" v-model="sel_tamanho">

                                           <option v-for="size in sizes" v-bind:value="size.url">
														    {{ size.text }}
														  </option>
                                  </select>
                                  <button class="btn btn-info btn-sm" v-on:click="selecionar">
                                  	Selecionar

                                  </button>
                         


                                </div>
			   	</div>
			</div>
			</div>

	</div>
</template>

<script>
    export default {
        props: ['id_load',  'onSave', 'onBack', 'show_back_button', 'onDelete'],
        data: function() {
            return {
              title: "",
            	legenda: "",
            	alt: "",
            	content: "" ,
              id: '', 
              url: '',

              show_message: "off",
              message_text: "",
              message_type: "success",
              interval_message: null,

              sizes: [],

              updated_at: "",
              sel_tamanho: "",

              editor_hab: false,
              disableButton: true,
              botao_voltar_visible: (this.show_back_button != null ?  this.show_back_button :  false )

            }
        },

        mounted() {


                   console.log("image select span close ");
                   //console.log( $("span.close") );

                    $("span.close").hide();

        	  if ( this.id_load == null || this.id_load == ""){

                         this.editor_hab = true;

                	return;
                }



                let self = this;
                var url =  window.URL_API +"midia/" + this.id_load; console.log("monted GET url: " + url );

                var data = new FormData();
     
                $.ajax({
                        type: "GET",
                        url: url,
                        contentType: false,
                        processData: false,
                        data: data,
                        success: function (retorno) {

                        	var item = retorno.item;
                            
                            console.log("LOAD: ");
                            console.log(item);

                            self.title = item.title;
                            self.alt = item.alt;
                            self.content = item.content;
                            self.legenda = item.legenda;
                            self.id = item.id;
                            self.url = item.url;
                            self.updated_at = item.updated_at;

                                  self.editor_hab = true;
			                       self.disableButton = false;

			                       var sizes = retorno.options_size;

			                       for ( var o = 0; o < sizes.length; o++ ){

			                       	          self.sizes.unshift( sizes[o] );
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

        }
        ,

        methods: {

        	selecionar(){

                    if ( this.sel_tamanho == ""){
                    	obj_alert.show("Atenção","Selecione o tamanho!","warning");
                    	return false;
                    }

                    var url = this.sel_tamanho;

                    if ( parent != null && parent != undefined ){

                    	var createImg = document.createElement("img");
                    	//createImg.src = url;

                      parent.obj_editor.addContent("<img src=\""+url+"\">");

                    	//parent.$('.summernote').summernote('editor.insertNode', createImg);
                    	parent.$.colorbox.close();
                    }

        	},

          botao_voltar(){
            var self = this;

                 if ( this.onBack != null && this.onBack != undefined ){
                  console.log("clique no voltar!");
                   this.onBack( self );
                 }
          },
          clear_message(){
                 this.show_message = "off";
                 clearInterval(this.interval_message);
          },
          onReturnDeleteUpload(retorno){
             //A exclusão foi feita!!
             console.log("Exclusão foi feita!!");
             if ( this.onDelete != null ){
                  this.onDelete(retorno);
             }
             //this.botao_voltar();

          },
          delete_image(tp){
            var self = this;

                    var fn_final = function(obj){
                              if ( obj.value != null && obj.value != undefined && obj.value == true ){
                                 obj_upload.delete_imagem( self.id, self);
                              }
                    } 

                    obj_alert.confirm("Atenção", "Deseja realmente excluir este arquivo?",
                             "question", fn_final);
          },
        	salvar(tp){



                let self = this;
                var url =  window.URL_API +"midia"; console.log("url: " + url );
                var method = "POST";

                if (this.id != null &&  this.id != ""){
                       method = "PUT"; url =  url + "/"+ this.id;
                }

                var txt_content = this.content;

                if ( self.editor_hab ){
                   txt_content = $(".note-editable").html();
                }

                 var data = {legenda: self.legenda, content: txt_content, 
                   alt: self.alt}

                   console.log("data sendo enviada: "); console.log(data);


                      $.ajax({
                              type: method,
                              url: url,
                              contentType: "application/x-www-form-urlencoded",
                              processData: true,
                              data: data,
                              success: function (retorno) {

                                console.log("retorno: "); console.log(retorno);
                                  
                                   self.id = retorno.item.id;

                                   if ( self.onSave != null ){
                                        self.onSave(retorno, 'form')
                                   }

                                  self.show_message = "on";
                                  self.message_text =  "Mídia atualizada com sucesso!";
                                  self.message_type = "success";

                                  this.interval_message = setInterval(self.clear_message, 6000); 


                                 // this.novo_item = "";
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

        	}

         }

     }
</script>
