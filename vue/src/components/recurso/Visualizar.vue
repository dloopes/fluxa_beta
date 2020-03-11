<template>
<div>
    <div v-if="form != null && form.image_url != null && form.image_url != ''" >
        <!-- class="box"  class="box-body" -->
        <!-- <div >
            <div class="box-header with-border" v-if="false">
              <h3 class="box-title">{{form.nome}}</h3>
            </div>
            <div >
                -->
        
                    <div class="col-xs-12" style="text-align:center; padding-top: 10px">
                            <img :src="form.image_url" class="img-rounded" style="max-height: 200px; max-width: 100%">
                    </div>

      <div class="col-xs-12"  v-if="form != null">
          <div >
                     <div class="col-xs-6" style="margin-left: 0px; padding-left: 0px ; padding-top: 10px">
                         <div class="row">
                         <ul style=" list-style-type: none; ">
                                <li><label>Status:</label> {{form.status_nome}}  </li>
                                <li v-if="form.dados != null"><label>Objetivo:</label> {{form.dados.objetivo}} </li>

                                <li v-if="descricao_ods != null && descricao_ods != ''"><label>ODS:</label> <div v-html="exibe_ods(descricao_ods)"></div> </li>
                                <li v-else><label>ODS:</label> {{form.dados.objetivo_ods}} </li>
                                
                         </ul>
                         </div>
                          
                     </div>
                     <div class="col-xs-6" style="margin-left: 0px; padding-left: 0px ">
                             <ul style=" list-style-type: none; ">
                                <li v-if="form.dados != null"><label>Categoria:</label> {{form.dados.categoria}}  </li>
                                <li v-if="form.dados != null"><label>Valores:</label> {{form.dados.recursos}} </li>

                         </ul>
                              
                     </div>


          </div>

          <div  class="row" v-if="qtde_arquivos >0">
                    <upload_folder :id_registro="form.id" id_tabela="recurso" :box_estilo="false" :pShowUpload="false" tamanho_coluna="6" />
          </div>
    </div>
    
  <!--  </div>
</div>  -->

</div>
</div>


</template>
<script>
import upload_folder from '../images/uploadFolder.vue';

export default {

    components:{
        upload_folder
    },


    props:{
        id_load: 
        { 
                    default: null,
                    type: Number
        }
    },
    methods:{

         exibe_ods(str){
                  return str.split(';').join('<br>');
         }
        

    },
    
    data: function() {
    return {
               form: null,
               qtde_arquivos: 0,
               descricao_ods: "",

           }
    },

     mounted() {

           let self = this;
                         obj_api.call("recursos/"+this.id_load, "GET", {} , function(response){
                             
                                        var item = response.item;
                                    
                                        self.form = item;
                                        self.qtde_arquivos = response.qtde_arquivos;
                                        self.descricao_ods = response.descricao_ods;
                         });


        }

}


</script>