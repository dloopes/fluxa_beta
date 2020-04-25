<template>
<div>
    <div v-if="form != null " >


        <div class="box box-widget">
            <div class="box-header with-border">
              <div class="user-block">
                <img class="img-circle" v-if="form.user.avatar != null && form.user.avatar.toString() != '' "
                     :src="form.user.avatar" :alt="form.user.nome">

                     
            <a href="#"  v-on:click="botao_voltar" class="pull-right" >
           <i class="fa fa-arrow-left"></i> Voltar para lista
        </a> 
                <span class="username"><a href="#">{{form.user.nome}}</a></span>
                <span class="description" >{{form.nome}}</span>
              </div>
              

              <!-- /.user-block -->
              <div class="box-tools" v-if="false">
                <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="" data-original-title="Mark as read">
                  <i class="fa fa-circle-o"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="col-xs-5">
                   <img class="img-responsive pad" style="max-height: 200px; max-width: 100%" v-if="form.image_url != null && form.image_url != ''" :src="form.image_url"  alt="Photo">
              </div>

              <div class="col-xs-7"  v-if="form != null">
                  <div >
                            <div class="col-xs-12" style="margin-left: 0px; padding-left: 0px ; padding-top: 10px">
                                <div class="row">
                                <ul style=" list-style-type: none; ">
                                        <li><label>Título:</label> {{form.nome}}  </li>
                                        <li><label>Status:</label> {{form.status_nome}}  </li>
                                        <li v-if="form.dados != null"><label>Objetivo:</label> {{form.dados.objetivo}} </li>

                                        <li v-if="form.dados != null"><label>Valores:</label> {{form.dados.recursos}} </li>

                                          <li v-if="descricao_cat != null && descricao_cat != ''"><label>Categoria:</label> <div v-html="exibe_ods(descricao_cat)"></div> </li>
                                        <li v-else><label>Categoria:</label> {{form.dados.categoria}} </li>

                                        <li v-if="descricao_ods != null && descricao_ods != ''"><label>ODS:</label> <div v-html="exibe_ods(descricao_ods)"></div> </li>
                                        <li v-else><label>ODS:</label> {{form.dados.objetivo_ods}} </li>
                                        
                                </ul>
                                 
                                 <div class="caption col-xs-12" style="padding-left: 35px">
                                      <button type="button" class="btn btn-success btn-flat" style="min-width: 150px;"
                                         v-if="form.id_usuario != null && id_user_my != null && id_user_my.toString() != form.id_usuario.toString()"
                                      v-on:click="call_fluxar(form)">Fluxar</button> 
                                 </div>
                                </div>
                                  
                            </div>


                  </div>

                  
                  
            </div>
 <div  class="row" v-if="qtde_arquivos >0" >
                            <upload_folder :id_registro="form.id" id_tabela="recurso" :box_estilo="false" :pShowUpload="false" tamanho_coluna="6" />
                

 </div>
  
              <div v-if="false">

              <button type="button" class="btn btn-default btn-xs"><i class="fa fa-share"></i> Share</button>
              <button type="button" class="btn btn-default btn-xs"><i class="fa fa-thumbs-o-up"></i> Like</button>
              <span class="pull-right text-muted">127 likes - 3 comments</span>
              </div>
            </div>
            <!-- /.box-body -->
        
            <!-- /.box-footer -->
          </div>
        
   <div class="box" v-if="form.qtde_fluxos > 0 ">
            <div class="box-header with-border" >
              <h3 class="box-title">Fluxos</h3>

            </div>
            <div  class="box-body" >
              
                                      <list_fluxos :id_form="id_load" ></list_fluxos>
     
            </div>
   </div>
        
        
</div>
</div>


</template>
<script>
import upload_folder from '../images/uploadFolder.vue';
import list_fluxos from './ListFluxos.vue';

export default {

    components:{
        upload_folder : upload_folder,
        list_fluxos: list_fluxos
    },


    props:{
        id_load: 
        { 
                    default: null,
                    type: Number
        },
        onBack:{
            type: Function,
            default: null
        }
    },
    methods:{

      
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

          


         exibe_ods(str){
                  return str.split(';').join('<br>');
         },
         botao_voltar(){
             if ( this.onBack != null ){
                 this.onBack();
             }

         }
        

    },
    
    data: function() {
    return {
               form: null,
               qtde_arquivos: 0,
               descricao_ods: "",
               id_user_my: null,
               descricao_cat: ""

           }
    },

     mounted() {

                 this.id_user_my = window.K_USER_ID;
           let self = this;
                         obj_api.call("recursos/"+this.id_load, "GET", {} , function(response){
                             
                                        var item = response.item;
                                    
                                        self.form = item;
                                        self.qtde_arquivos = response.qtde_arquivos;
                                        self.descricao_ods = response.descricao_ods;
                                        self.descricao_cat = response.descricao_cat;
                         });


        }

}


</script>