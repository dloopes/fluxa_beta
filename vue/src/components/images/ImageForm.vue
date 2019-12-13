<template>
	<div>

		     <section class="content-header">

                    <section class="col-lg-8">
                          <h1>
                          Mídia

                          </h1>
                          <ol class="breadcrumb" style="display: none">
                            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                            <li><a href="#">Forms</a></li>
                            <li class="active">General Elements</li>
                          </ol>
                        </section>
                        <section class="col-lg-2" style="padding-top: 30px">
                            <a href="#" v-if="botao_voltar_visible"  v-on:click="botao_voltar">
                               <i class="fa fa-arrow-left"></i> Voltar para biblioteca de mídia
                            </a> 
                        </section>
                          <section class="col-lg-2 pull-right" style="padding-top: 30px">
                            


                                         <button type="submit" class="btn btn-default"
                                          v-bind:disabled="disableButton"
                                          v-on:click="salvar('draft')">Salvar</button> 



                                         <button type="submit" class="btn btn-default"
                                          v-bind:disabled="disableButton"
                                          v-on:click="delete_image('draft')">Excluir</button> 
                        </section>
                    </section>

  <div class="col-lg-12">
          <div v-if="show_message == 'on' " class="alert alert-success">
                {{message_text}}
          </div>
</div>
  <div class="col-lg-12">
       <div class="box">
   <div class="box-body">


                <section class="col-lg-6">


                       <img id="image_details" v-bind:src="url" style="max-height: 90%; max-width: 94%" >

                </section>
                <section class="col-lg-6">


                         <div v-if="updated_at != '' && updated_at != null "><b>Última atualização:</b> {{updated_at | datetime_show}} 
                         </div>
                         <div v-if="url != '' "><b>URL: </b><a v-bind:href="url" target="_blank">{{url}}</a>
                         </div>
                         

                                <div class="form-group">
                                  <label for="image_legenda">Tag Title</label>
                                      <textarea class="form-control" v-model="title" name="image_title" 
                                     id="image_title"  style="height: 40px"></textarea> 

                                </div>


                                 <div class="form-group">
                                  <label for="image_alt">Texto Alternativo</label>
                         
                                   <input class="form-control" name="image_alt" 
                                          id="image_alt" v-model="alt"
                                          type="text" placeholder="Texto Alternativo" >


                                </div>


                                 <div class="form-group">
                                  <label for="image_content">Descrição</label>
                         
                                      <textarea class="form-control summernote" v-model="content" name="image_content" 
                                     id="image_content"  style="height: 200px"></textarea> 
                                </div>

                </section>
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

              updated_at: "",

              editor_hab: false,
              disableButton: true,
              botao_voltar_visible: (this.show_back_button != null ?  this.show_back_button :  false )

            }
        },

        mounted() {

        	  if ( this.id_load == null || this.id_load == ""){

                       /*
                         $('.summernote').summernote(
				                      {
				                      	height: 200, //Vou tirar o upload de imagem.
                                toolbar: [ 
                                      [ 'style', [ 'style' ] ],
                                      [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
                                      [ 'fontname', [ 'fontname' ] ],
                                      [ 'fontsize', [ 'fontsize' ] ],
                                      [ 'color', [ 'color' ] ],
                                      [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
                                      [ 'table', [ 'table' ] ],
                                      [ 'insert', [ 'link'] ],
                                      [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
                                  ]
				                      });
                              */
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
                            //self.legenda = item.legenda;
                            self.id = item.id;
                            self.url = item.url;
                            self.updated_at = item.updated_at;

                             /* 
                            $(document).ready(function() {
				                          //	console.log("já existo? " ); console.log( $ );
								                $('.summernote').summernote(
				                      {
				                      	placeholder: self.content,
				                      	height: 400
				                      }
              								  	);
                                 //context.invoke('editor.insertText', data.element);
                                          

              								  	 console.log("cheguei aqui?");
              								}); */

                               self.editor_hab = true;
                                           self.disableButton = false;
                            //self.loadcategories( retorno.categories );
                            //self.items = retorno;
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

                 var data = {title: self.title, content: txt_content, 
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
