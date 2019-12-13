<template>
	<div>
  <section  v-bind:style="style_list()">
     
      <div >

       <div class="col-lg-12"  style="margin-top: 15px">
               <div class="col-lg-3" >
                 <table>
                     <tr>
                         <td>

                               <h3 style="margin-left: 0px; margin-top: 0px">Galeria de Mídia</h3>
                         </td>
                         <td style="padding-left: 20px">
                                   <button v-if="show_botao_upload()" v-on:click="botao_mostra_upload" class="btn btn-xs btn-default">Adicionar Nova</button>
                         </td>
                     </tr>
                 </table>
               </div>
               <div class="col-lg-6" >
                 <span v-if="exibe_carregando"> Obtendo biblioteca de mídia.. 
                        <img v-bind:src="img_loading | base_url" /></span>

               </div>
               <div class="col-lg-3" >
                  <div class="input-group pull-right">
                          <input type="text" placeholder="Digite para pesquisar" v-model="texto_pesquisa"
                           maxlength="300" class="form-control" v-on:keyup.enter="pesquisar" >
                           <span class="input-group-addon">
                            <button style="border: none; background: none"
                              v-on:click="pesquisar" ><i class="fa fa-search" ></i></button>
                            </span>
                  </div>
     
                 
               </div>
                    <div >
     <upload v-if="v_visivel_upload" v-bind:onSave="onSave"></upload>
      </div>
       </div>
       <div class="col-lg-12" >
               


                      <div v-bind:id="getID('image_list')" class="col-lg-12">
                                   Carregando...

                      </div>
                      <div v-bind:id="getID('div_pagination')" >

                      </div>
                      <div  v-bind:id="getID('div_template_gallery')"  style="display: none" >

                                 <a class="example-image-link" href="#!" myid="{id}" myindx="{myindx}" ><img class="example-image"
                                  style="max-height: 150px; max-width: 150px"
                                  src="{image_thumb}"  alt="{image_title}"
                                /></a>


                      </div>
        </div>


     </div>

  </section>

      <imageform v-if="action =='form'" v-bind:id_load="id" 
                        v-bind:onSave="onSave"  v-bind:onDelete="onDelete"
                    show_back_button="true" v-bind:onBack="onBack"></imageform>

                    <imageselect v-if="action =='formsel'" v-bind:id_load="id" 
                        v-bind:onSave="onSave"  v-bind:onDelete="onDelete"
                    show_back_button="true" v-bind:onBack="onBack"></imageselect>

</div>
</template>

<script>
    export default {
        props: [ 'pPageSize', 'pColumnSize', 'pShowUpload', 'pUniqueID', 'pEhModal'],

        data: function() {
            return {

              action: "list",
            	items: [],
              id: "",
              index_selecionado: "",
              texto_pesquisa: "",
              pageNumber: 1,
              pageSize: (this.pPageSize != null ? this.pPageSize :  15),
              columnSize: (this.pColumnSize != null ? this.pColumnSize : 5),
              exibe_carregando: false,
              unique_id: (this.pUniqueID != null ? this.pUniqueID : ""),
              v_visivel_upload: false,
              img_loading: "loading.gif"
            }
        },
        methods: {

          getID(tip){
                return this.unique_id + tip;
          },

          show_botao_upload(){
                
                if (  this.pShowUpload != null &&  this.pShowUpload == "false" ){
                   return false;
                }

                return true;
          },
          show_upload(){
                return this.v_visivel_upload;
          },
          botao_mostra_upload(){
                  this.v_visivel_upload = !this.v_visivel_upload;
          },


          style_list(){
                if ( this.action == "form" || this.action == "formsel" ){
                  return "display:none";
                }
                return "";
              },

          pesquisar(){

             let self = this;
             self.exibe_carregando = true;
               var data = new FormData();

                 $(document).ready(function() {
                  console.log("URL: " + window.URL_API +"midia" );
                   

                    let url = window.URL_API +"midia?filtro="+self.texto_pesquisa;

                    $.ajax({
                            type: "GET",
                            url: url,
                            contentType: false,
                            processData: false,
                            data: {},
                            success: function (retorno) {

                                         //self.load_images(retorno);
                                        // console.log("cheguei aqui?");
                                         self.items = retorno;

                                        $('#'+self.unique_id+'div_pagination').pagination({
                                            dataSource: retorno,

                                            pageSize: self.pageSize,
                                            callback: function(data, pagination) {
                                                // template method of yourself
                                                //var html = template(data);
                                                //dataContainer.html(html);
                                                self.load_images(data, pagination);
                                               self.exibe_carregando = false;
                                            }
                                        })

                             
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
               
                } );
                
              


          },

          load_images(itens, pagination){

            console.log("object, pagination: "); console.log( pagination );

             var template = $("#div_template_gallery").html();
             var self = this;

             var html = "<table id=\""+this.getID("table_data_gallery")+"\" class='table table-striped table_data'><tbody><tr>";
             var max_colunas = this.columnSize;
             var conta_coluna = 0;

             console.log("recebido: " + itens.length );

             var pageSize = pagination.pageSize;
             var pageNumber = pagination.pageNumber;

             self.pageNumber = pageNumber;

             for ( var i = 0; i < itens.length; i++){

                       var html_item = template; // itens[i];
                       html_item = html_item.replace("{image_url}", itens[i].url );
                       html_item = html_item.replace("{image_thumb}", itens[i].thumbnail );
                       html_item = html_item.replace("{image_title}", itens[i].title );
                       html_item = html_item.replace("{id}", itens[i].id );
                       //myindx indx

                       var indx = i + (pageSize * (pageNumber-1));
                       html_item = html_item.replace("{myindx}", indx.toString() );
                   
                       html += "<td>"+ html_item +"</td>";
                       conta_coluna++;
                       if ( conta_coluna == max_colunas ){
                             html += "</tr><tr>";

                             conta_coluna = 0;
                       }


             }

             html += "</tr></tbody></table>";

             $("#"+self.unique_id+"image_list").html( html );

    //.table_data
    //
             $('#'+this.getID("table_data_gallery")+' tbody').on( 'click', 'a', function () {

                var id =  $(this).attr("myid");
                var myindx =  $(this).attr("myindx");
                console.log("recebido a ID " + id );

                self.editar( id , myindx);
              } ); 
             //image_url  image_thumb  image_title
            //console.log("Itens recebidos " + itens.length);

          },

          getType(){
                if ( this.post_type != null && this.post_type != undefined )
                  return this.post_type;

                return "post";
          },

        	onBack ( objPost ){
              //Clicou no back button.
              this.id = ""; //Voltando para a lista
              this.action = "list";
        	},

        	open_form (id){
                    this.id = "";
                    this.action = "form";

        	},

        	editar ( id , myindx ){

        		this.id = id;
            let action = "form";

            if ( this.pEhModal != null && this.pEhModal == "1"){
                action = "formsel";
            }
        		this.action =  action;
            this.index_selecionado = myindx;
            //console.log("modal");
           // console.log( $('#modal-default') );
           // $('#modal-default').appendTo("body").modal('show');
        	},
          onDelete(id){
                    this.id = "";
                    this.action = "list"; 
                    console.log("registro excluido " + this.index_selecionado+" qtde total: " + this.items.length );
                    this.items.splice(parseInt(this.index_selecionado), 1);

                    console.log("after splice " + this.index_selecionado+" qtde total: " + this.items.length );

                    this.index_selecionado = "";
                    this.refresh_table();
          },
        	onSave(data, tipo){

          
          if ( tipo == "upload"){

                            var self = this;
                            console.log("recebido.. ");
                             for ( var i = 0; i < data.length; i++){
                                        
                                        self.items.unshift(data[i]);
                                         console.log(data[i]);
                             }

                             self.create_pagination();
                          
          }

        	},

        	refresh_table(){

               // load_images

                   if ( this.pageSize > this.items.length )
                      this.pageNumber = 1;

                  var itens_load = [];
                  var indx_inicio =  (this.pageSize *  ( this.pageNumber -1 ));
                  var indx_final = indx_inicio + this.pageSize;

                  if ( indx_final > this.items.length ){
                      indx_final = this.items.length;
                  }

                  for( var i  = indx_inicio ; i < indx_final; i++  ){
                       itens_load[itens_load.length] = this.items[i];
                  }

                  var objFake = {pageSize: this.pageSize, pageNumber: this.pageNumber};

                  this.load_images(itens_load, objFake);

        	},

          create_pagination(){
            var self = this;
                               $('#'+self.unique_id+'div_pagination').pagination({
                                                        dataSource: self.items,

                                                        pageSize: self.pageSize,
                                                        callback: function(data, pagination) {
                                                            // template method of yourself
                                                            //var html = template(data);
                                                            //dataContainer.html(html);
                                                            self.load_images(data, pagination);
                                                        }
                                                    });

          }
        },
        computed: {
                
        },
        mounted() {

        	    this.pesquisar();

              if ( this.pEhModal != null && this.pEhModal=="1"){

                    $("span.close").hide();
              }
              

        	}
     }
 
    </script>
