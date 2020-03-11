<template>
<div>
<div class="col-xs-12 col-md-12" :style="estilo_lista()" >
   <div class="col-xs-12 col-md-12" >

       <div class="input-group">
                      <input type="text" name="tx_pesquisar" v-model="filtro.filtro"
                       @keydown.enter="carregar"
                       placeholder="Digite para pesquisar" class="form-control">
                      <span class="input-group-btn">
                            <button type="button" class="btn btn-info btn-flat" v-on:click="carregar">OK</button>
                          </span>
                    </div>

   </div>

   <div class="col-xs-12 col-md-12" >
   &nbsp;
     <div v-if="loading">
         <i><i class="fa fa-spinner"></i> Carregando</i>
     </div>
   </div>
  <div v-if="!loading" >
    <div  v-for="(item,index) in items" :key="index" class="col-xs-3 col-md-3">

                 <div class="thumbnail">       
                     <a href="#!" v-on:click="abrir(item)">
                        <img v-if="item.image_url != null " :src="item.image_url"  
                                 class="img-rounded" :alt="item.nome">

                                 <div class="caption">
                                      <p ><b v-html="item.nome"></b> </p>
                                      <p ><b>Categoria: </b> <span v-html="item.categoria"></span></p>
                                      <p ><b>Status: </b> <span v-html="item.status"></span></p>
                                    
                                      
                                 </div>
                                 </a>
                                 
                                 <div class="caption">
                                      <p > <button type="button" class="btn btn-success btn-flat" style="min-width: 150px;"
                                         v-if="item.id_usuario != null && id_user_my != null && id_user_my.toString() != item.id_usuario.toString()"
                                      v-on:click="call_fluxar(item)">Fluxar</button>   </p>
                                 </div>
                    </div>


    </div>
  </div>  
  
   <div class="col-xs-12 col-md-12" >
     <div v-bind:id="getID('div_pagination')"  style="text-align: right">

      </div>
  </div>  
    
  
  
</div>
<div class="col-xs-12 col-md-12" v-if="acao=='form' && id_load != null " >

                              <visualizar2 :id_load="id_load" :onBack="onBackVisualizar" ></visualizar2>

</div>

     



    <div id="myModal" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">{{titulo}}</h4>
                    </div>
                    <div >   <!-- class="modal-body" -->
                         <div  v-if="false && acao=='form' && id_load != null "  >
                              <visualizar :id_load="id_load" ></visualizar>
                              
                         </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                    </div>

                </div>
        </div>

</div>
    
</template>
<script>
import visualizar from './Visualizar.vue';
import visualizar2 from './Visualizar2.vue';
export default {

         components:{
             visualizar,
             visualizar2
         },


          data: function() {
            return {
                                    filtro: {
                                        paginacao: 1,
                                        pagina: 1,
                                        qtde_por_pagina: 8,
                                        tipo_recurso: "iniciativa",
                                        filtro: "",
                                        minhas: "",
                                    },
                                    items: [],
                                    id_load: null,
                                    unique_id: "recurso_",
                                    acao: "listar",
                                    loading: false,
                                    titulo: "",
                                    id_user_my: null,
                                    
            }
        },
        methods:{

            onBackVisualizar(){
                     this.acao = "listar";
            },

            estilo_lista(){

                if ( this.acao == "listar"){
                    return "";
                }

                return "display:none"

            },

            call_fluxar(item){

                 
                 var data = {
                         "retorno": "json",
                         "id_recurso": item.id,
                         "my_user_id": this.id_user_my
                 }

                 
                         obj_api.call("fluxo", "POST", data , function(response){
                              var retorno = response;
                              
                              //Vou encaminhar este usuário para a tela de fluxo..
                              document.location.href= retorno.url;
                         });


                      //chame aqui o modal para fluxar ou o que for feito no outro...
                      /*
                      <form method="POST" action="/sistema/fluxo" id=<?php echo("form_".$recurso->getId())?>> 
	        		<div class="text-left">
		        		<input type="hidden" name="id_recurso" value=<?php echo($recurso->getId())?> /> 
		        	 	<input type="button" style="min-width: 150px;" class="btn btn-success btn-flat" title="Fluxar" onclick="sendFormFluxo(<?php echo("form_".$recurso->getId())?>);" value="Fluxar"/>
	        	 	</div>
	        	</form>	
                  */
            },

              getID(tip){
                return this.unique_id + tip;
             },
             botao_voltar(){
                 this.acao = "listar";

             },
            abrir(item){
                self = this;
                this.id_load = null;
                this.acao = "form";
                setTimeout(function(){

                         self.id_load = item.id;
                         self.titulo = item.nome;
                      //   $("#myModal").modal();
                }, 100);
            },
            create_pagination(response){
                    var self = this;

                    
                                   console.log("totalNumber? " + response.total );
                               $('#'+self.unique_id+'div_pagination').pagination({
                                                        dataSource: response.data,
                                                        totalNumber: response.total,

                                                        pageSize: self.filtro.qtde_por_pagina,
                                                        callback: function(data, pagination) {

                                                                                                            
                                                            var pageSize = pagination.pageSize;
                                                            var pageNumber = pagination.pageNumber;
                                                            self.filtro.pagina = pageNumber;
                                                            self.load_data(false);
                                                            // template method of yourself
                                                            //var html = template(data);
                                                            //dataContainer.html(html);
                                                           // self.load_images(data, pagination);
                                                        }
                                                    });

          },
          carregar(evt){
              console.log("carregar? ", evt );
              this.filtro.pagina  = 1;
              this.load_data( true );


          },
          load_data(paginar){

           let self = this;
           this.loading = true;
           let str_comp = obj_api.serialize( this.filtro );

           

                         obj_api.call("recursos?"+str_comp, "GET", {} , function(response){
                              self.items = response.data;
                              if ( paginar ){
                                  self.create_pagination(response);
                              }
                              self.loading = false;
                              console.log(response);
                         });

          }
        },

    
        mounted() {
                 this.id_user_my = window.K_USER_ID;

                 this.load_data(true);

        }

}
</script>