<template>
 <div>
   <div class="col-xs-12" >
    <h3 style="margin-left: 1%">{{getTitulo()}}</h3>
			<upload v-bind:onSave="onSave" v-bind:ptype="getType()"
       v-bind:msg_tamanho="msg_tamanho"></upload>
   </div>

   <div class="col-xs-12" >
 <span v-if="exibe_carregando"> Obtendo imagens.. 
                        <img v-bind:src="img_loading | base_url" /></span>
                         <div style="padding-left: 1%" ><i v-if="items.length > 0 " v-html="getMsgOrdenacao()"></i>
                         </div>
          <div id="div_list_upload">


          </div>

   </div>

<div id="banner_dialog" style="background: white">

     <banner-detail v-bind:id_load="id_load_banner"
         v-if="in_edit" v-bind:ptype="ptype" com_classes="0"></banner-detail>
</div>


</div>


</template>
<style>
  .img_thumb_banner{
       max-height: 100px;

  }

  #sortable { list-style-type: none; margin: 0; padding: 0; width: 99%; }
  #sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: auto !important; 
  }
  #sortable li span { position: absolute; margin-left: -1.3em; font-size: 11px; height: auto !important; }
</style>
<script>
    export default {
        props: ['ptype', 'msg_tamanho' ],

        data: function() {
            return {

                items: [], 
                exibe_carregando: false, 
                ids_ordem: "",
                b_type: null ,
                img_loading: "loading.gif",
                id_load_banner: "",
                in_edit: false,
                dialog: null
            }
        },
        beforeRouteUpdate(to) {

          console.log("Before route vamos mostrar aqui ");
          console.log( to.params );
          this.b_type  = to.params.ptype;
          this.get_api_list();

        },

        mounted() {
             if ( this.$router.currentRoute.name != null ){
              let new_route = this.$router.currentRoute.name;

              if ( new_route =="btopo" ||  new_route =="bparc")
                   this.b_type  = new_route;

                 //this.post_type = new_route; //   "page"
                 //this.type =  new_route;
            }

            let self = this;


                     this.get_api_list();


                       $( function() {
                        self.dialog = $( "#banner_dialog" ).dialog({
                          autoOpen: false, 
                          width: 800,
                          height: 500,
                          close: self.closeModal,
                        });
                     
                       // $( "#opener" ).on( "click", function() {
                       //   $( "#dialog" ).dialog( "open" );
                       // });
                       console.log("Dialog carregado: "); console.log( this.dialog );
                      } );
        },

        methods:{

           closeModal(){

                    this.in_edit = false;

           },
           getMsgOrdenacao(){
                 let b_type = this.getType();
                 let msg = "Deslize os arquivos para cima ou para baixo para mudar a ordem de exibição";

            if ( b_type == "principal"){
               msg = "Deslize os arquivos para cima ou para baixo para mudar a ordem de exibição. Os arquivos serão exibidos no banner conforme a ordem estabelecida abaixo.";

            }

             if ( b_type == "btopo"){
               msg = "Deslize os arquivos para cima ou para baixo para mudar a ordem de exibição. O primeiro arquivo é o que será exibido no banner topo.";
             }
           
             if ( b_type == "bparc"){
               msg = "Deslize os arquivos para cima ou para baixo para mudar a ordem de exibição. Os arquivos serão exibidos no banner conforme a ordem estabelecida abaixo.";
             }

               if ( b_type == "bmodal"){
               msg = "Deslize os arquivos para cima ou para baixo para mudar a ordem de exibição. O primeiro arquivo é o que será exibido no modal do site.";
             }

              return msg;  


           },

           getTitulo(){

            let b_type = this.getType();

            if ( b_type == "principal")
              return "Banner Rotativo";


            if ( b_type == "btopo")
              return "Banner de Topo";


            if ( b_type == "bparc")
              return "Banner de Parceiros";

           },

                            getType(){

                                     if ( this.b_type != null )
                                        return this.b_type;
                                      
                                      if (this.ptype == null && this.b_type == null )
                                        return "principal";

                                    


                                      return this.ptype;
                            },

                            onSave(data, tipo){

                                  
                                  if ( tipo == "upload"){

                                                    var self = this;
                                                    console.log("recebido.. ");
                                                     for ( var i = 0; i < data.length; i++){
                                                                
                                                                self.items.unshift(data[i]);
                                                               //  console.log(data[i]);
                                                     }

                                                     this.load_itens();

                                                     //self.create_pagination();
                                   }
                                                  
                            },
                            saveOrdem(){

                                    let url = window.URL_API +"bannerlist";


                                    var data = {list: this.ids_ordem};

                                    // console.log( JSON.stringify(data) );
                                        $.ajax({
                                                type: "PUT",
                                                url: url,
                                                contentType: "application/json",
                                               // contentType: false,
                                               // processData: false,
                                                data: JSON.stringify(data) ,
                                                success: function (retorno) {

                                                     //   console.log("Ordem salva!");
                                                      //  console.log(retorno);
                                                 
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
                            get_api_list(){


                                 let self = this;
                                 let ptype = this.getType();

                                 self.exibe_carregando = true;
                                
                                 var data = new FormData();

                                     $(document).ready(function() {
                                      console.log("URL: " + window.URL_API +"midia" );
                                       

                                        let url = window.URL_API +"midia?type_image="+ ptype;

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

                                                             self.load_itens();


                                                 
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



                            load_itens(){

                                let self = this;
                                let ptype = this.getType();


                                let html = '<ul id="sortable">';

                                for ( var i = 0; i < this.items.length; i++ ){

                                    var item = this.items[i];

                                    html += '<li class="ui-state-default" style="height: auto !important"><div >';
                                     html += '<input type="hidden" name="banner_'+item.id+'" value="'+item.id+'">';
                                     html += '<table style="width: 99%"><tr>';
                                     html += '<td style="width: 200px">';


                                     html += '<img class="img_thumb_banner" src="' + item.thumbnail + '" /> </td>';
                               
                                     html += '<td>'+item.filename+'</td>';

                                     html += '<td valign="middle" style="text-align: right">';

                                     html += '<button class="btn btn-default img_thumb_edit" '+
                                            '  myid="'+item.id+'"><i class="fa fa-edit"></i></button>';


                                       html += '<button class="btn btn-default img_thumb_view" '+
                                            '  myid="'+item.id+'" myimg="'+item.url+'"><i class="fa fa-eye"></i></button>';

                                     html += '<button class="btn btn-default img_thumb_trash" '+
                                            '  myid="'+item.id+'"><i class="fa fa-trash"></i></button></td>';
                                    html += '</tr></table></div>';
                                    html += '</li>';

                                }
                                html += "</ul>";
                                $("#div_list_upload").html(html);
                               
                                this.exibe_carregando = false;
                                this.load_sortable();



                               $('button.img_thumb_trash').click( function () {

                                        var id =  $(this).attr("myid");
                                        var myindx =  $(this).attr("myindx");
                                        console.log("recebido a ID " + id );


                                             var fn_final = function(obj){
                                                          if ( obj.value != null && obj.value != undefined && obj.value == true ){
                                                             obj_upload.delete_imagem( id, self);
                                                          }
                                                } 

                                                obj_alert.confirm("Atenção", "Deseja realmente excluir esta imagem?",
                                                         "question", fn_final);

                                        //self.editar( id , myindx);
                                      } ); 



                               $('button.img_thumb_edit').click( function () {

                                        var id =  $(this).attr("myid");
                                        var myindx =  $(this).attr("myindx");
                                    
                                        self.in_edit = true;
                                        self.id_load_banner = id;
                                         self.dialog.dialog( "open" );
                                      } ); 

                                 $('button.img_thumb_view').click( function () {

                                        var id =  $(this).attr("myid");
                                        var url =  $(this).attr("myimg");
                                         window.obj_editor.openModal(url, 900, 400);

                                 } );
                                  

                            },

                            onReturnDeleteUpload(){
                               this.get_api_list();

                            },

                            load_sortable(){

                                var self = this;

                                var fn_update = function(){
                                                    var ar = new Array();

                                                   var soli = document.getElementById("sortable");

                                                   var inputs = soli.getElementsByTagName("input");

                                                   for ( var i = 0; i < inputs.length; i++){
                                                           ar[ ar.length ] = inputs[i].value;
                                                   }

                                                   self.ids_ordem  = ar.join(",");
                                                   self.saveOrdem();

                                                  //  console.log( ar.join(",") );
                                                }

                                         $( function() {
                                            $( "#sortable" ).sortable();
                                            $( "#sortable" ).disableSelection();
                                          } );

                                          $( "#sortable" ).sortable({
                                                stop: fn_update
                                            });


                            }
            }


 }
 </script>   