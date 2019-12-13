<template>
  <div>

         <section class="content-header">
              
                    <section class="col-lg-6">
                          <h1>
                          {{getTitulo()}}

                          </h1>
                     </section>
                      <section class="col-lg-6 pull-right" >
                            

                              <div style="text-align: right; padding-top: 30px">
                                         <button type="submit" class="btn btn-primary"
                                          v-bind:disabled="disableButton"
                                          v-on:click="salvar('draft')">Salvar</button> 
                              </div>            

                        </section>
                    </section>

  <div class="col-lg-12">
          <div v-if="show_message == 'on' " class="alert alert-success">
                {{message_text}}
          </div>
</div>
  <div class="col-lg-12">


                <section class="col-lg-12">


                       <img id="md_image_details" 
                       v-bind:src="url" style="max-height: 100px; max-width: 100px" />
                          
                        <div v-if="updated_at != '' && updated_at != null "><b>Última atualização:</b> {{updated_at | datetime_show}} 
                         </div>
                         <div v-if="url != '' "><b>URL IMG: </b><a v-bind:href="url" target="_blank">{{url}}</a>
                         </div>

                </section>

                <section class="col-lg-12">

                       <div class="form-group">
                                  <label for="md_image_title">Tag Title</label>
                         
                                   <input class="form-control" name="md_image_title" 
                                          id="md_image_title" v-model="title"
                                          type="text" placeholder="Tag Title" maxlength="100" >


                     </div>
                      <div class="form-group">
                                  <label for="md_image_title">Tag Alt</label>
                         
                                   <input class="form-control" name="md_image_alt" 
                                          id="md_image_alt" v-model="alt"
                                          type="text" placeholder="Tag Alt" maxlength="50" >


                     </div>
                       
                </section>

                <section class="col-lg-9">
                       <div class="form-group">
                                  <label for="md_image_url_abrir">URL Abrir</label>
                         
                                   <input class="form-control" name="md_image_url_abrir" 
                                          id="md_image_url_abrir" v-model="url_abrir"
                                          type="text" placeholder="URL para abrir ao clicar na imagem" maxlength="300" >


                     </div>
                </section>
             
                <section class="col-lg-3">
                              <div class="form-group">
                                  <label for="md_image_abrir_como">Abrir como</label>

                                  <select id="md_image_abrir_como" name="md_image_abrir_como"
                                           v-model="abrir_como"
                                           class="form-control">
                                         <option v-for="choice in choices" 
                                          v-bind:value="choice.value">{{ choice.text }}</option>
                                  </select>
                         

                     </div>
                </section>


</section>


  <section class="col-lg-12">
<upload-unico 
   v-if="id !='' && parseInt(id) > 0 "
v-bind:id_parent="id" title="Imagem Mobile" com_classes="0" ptype="b:mobile"></upload-unico>

</section>


    <div class="col-lg-12">
                            <h3>Programar Exibição?</h3>
                                <div class="col-xs-4" style="padding-left: 0px; margin-left: 0px">
                                 <input type="text" class="form-control" 
                                          placeholder="Data Início"
                                          id="prog_dtini" 
                                          v-bind:value="prog_dtini | date_show"
                                          v-on:focus="setdatepicker"
                                          v-on:change="change_data"
                                           style="width: 100px" 
                                   />
                               </div>
                                <div class="col-xs-4" style="padding-left: 0px; margin-left: 0px">
                               
                                   <input type="text" class="form-control" 
                                          v-on:focus="setdatepicker"
                                          id="prog_dtfim" 
                                            v-on:change="change_data"
                                          v-bind:value="prog_dtfim | date_show"
                                          placeholder="Data Fim"  style="width: 100px"
                                   />

                            </div>
                             <div class="col-xs-4" >
                                  <div v-for="item in week" class="col-xs-6" style="margin-left: 0px; padding-left: 0px">
                                           
                                           <input type="checkbox" 

                                           v-bind:checked="ischecked(item.id)"

                                           class="chk_category" v-bind:value="item.id">
                                           {{item.text}}



                                  </div>

                             </div>
                             <div class="col-xs-12" style="margin-left: 0px; padding-left: 0px">
                                  <i><b>Atenção! </b> para a programação de exibição funcionar, preencha todos os
                                    campos: Data Início, Data Fim e os dias da semana desejados.</i>
                             </div>

                               </div>
          </div>

    </div>
    </div>
</template>

<script>
  // title alt url_abrir choices  abrir_como
    export default {
        props: ['id_load', 'ptype',  'onBack', 'show_back_button', 'onDelete'],
        data: function() {
            return {
              title: "",
              legenda: "",
              alt: "",
              content: "" ,
              id: '', 
              url: '',
              url_abrir :"",
              abrir_como: "",
              
              prog_dtini: "",
              prog_dtfim: "",
              prog_dia_semana: "",

              choices: [{value: "_self","text":"Mesma Janela"},
                        {value: "_blank","text":"Nova Janela"}],


              week: [
                        {id: "0",text:"Domingo"},
                        {id: "1",text:"Segunda"},
                        {id: "2",text:"Terça"},
                        {id: "3",text:"Quarta"},
                        {id: "4",text:"Quinta"},
                        {id: "5",text:"Sexta"},
                        {id: "6",text:"Sábado"},

                        ],


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
                                          self.url_abrir = item.url_abrir;
                                          self.abrir_como = item.abrir_como;
                                          self.updated_at = item.updated_at;

                                          self.prog_dtini = item.prog_dtini;
                                          self.prog_dtfim = item.prog_dtfim;
                                          self.prog_dia_semana = item.prog_dia_semana;

                                          self.editor_hab = true;
                                          self.disableButton = false;

                                   console.log("cheguei aqui?");
                              
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

           change_data(event){

            let self = this;

                if ( event.target.id =="prog_dtini"){
                  self.prog_dtini = obj_mask.dataBanco(  event.target.value );
                }

                 if ( event.target.id =="prog_dtfim"){
                  self.prog_dtfim = obj_mask.dataBanco(  event.target.value );
                }


           },

          getweek (){
                     
                     var ids = $(".chk_category:checked").map(
                                  function () {return this.value;}).get().join(",");

                     return ids;

            },

            ischecked( id ){

              if ( this.prog_dia_semana == null)
                return false;

              var selecteds = this.prog_dia_semana.split(',');

                if ( selecteds != null && selecteds != undefined ){
                               for ( var i = 0; i < selecteds.length; i++ ){
                                   if ( selecteds[i] == id ){
                                       return true;
                                   }
                               }
                }

                return false;

            },
          setdatepicker(event){

            let self = this;

                obj_editor.onSelectEvent =  function(dateText, inst){
                  console.log("Mudando dateText: " + dateText );
                  console.log( inst );

                  if ( inst.id =="prog_dtini"){

                        self.prog_dtini = obj_mask.dataBanco(dateText );

                  }
                  if ( inst.id =="prog_dtfim"){
                    
                        self.prog_dtfim = obj_mask.dataBanco(dateText );
                  }

                };

               obj_editor.focus_data( event.target );
              /*
            var obj_id = event.target.id;

             if ( ! $("#"+obj_id).hasClass("hasDatepicker") ){
                          obj_editor.loadCalendar("#"+obj_id); 
                          //$("#"+obj_id).datepicker();
                          $("#"+obj_id).focus();
                          $("#"+obj_id).click();
                          console.log("tentando adicionar o datepicker");
               }

               */
          },

          getTitulo(){
                   return obj_upload.getTitulo(this.ptype);
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
          OpenImage(url){
                    
                    obj_editor.openModal(url, 600, 400);

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
          returnSave(retorno, tp){

            let self = this;

              console.log("retorno: "); console.log(retorno);
                                  
                                   self.id = retorno.item.id;

                                  

                                  self.show_message = "on";
                                  self.message_text =  "Banner atualizado com sucesso!";
                                  self.message_type = "success";

                                  this.interval_message = setInterval(self.clear_message, 6000); 


          },

          salvar(tp){
                let self = this;

                self.prog_dia_semana = self.getweek();

                obj_upload.update_banner(self, 'bannermobile');

          }

         }

     }
</script>
