<template>
  <div>
<!--

import RecursoCadastrosListCadTable from './components/recurso_cadastros/RecursoCadastrosListCadTable'
import RecursoCadastrosListConsTable from './components/recurso_cadastros/RecursoCadastrosListConsTable'


Vue.component('recurso_cadastros_list_cad_table', RecursoCadastrosListCadTable);
Vue.component('recurso_cadastros_list_cons_table', RecursoCadastrosListConsTable );
{{titulo_coluna_inicio}}

-->
         <table class="table table-bordered table-striped">
             <thead>
             	<tr>
                     
                      <th>Forma de Contato</th>  
                      <th>Detalhes</th>  
                     <th >
                       <button class="btn btn-default pull-right" v-on:click="add" type="button"
                       ><i class="fa fa-plus"></i></button>

                     </th>
             	</tr>
             </thead>
             <tbody>
                 <tr v-for="(item, index) in items" :key="index">
				  
                        <td>  <input type="text" 
                                                                    v-model="item.descricao"
                                                                    v-on:change="change_value"
                                                                    maxlength="300"
                                                                    class="form-control"
                                                                    v-bind:id="getIDItem('descricao', index)" style="max-width: 200px">
                                          
                            </td> 
                                 <td>  <input type="text"   v-model="item.texto"
                                                 v-on:change="change_value"
                                                                    maxlength="1000"
                                                                    class="form-control"
                                                                    v-bind:id="getIDItem('texto', index)">
                                          
                            </td> 
                    
                     <td>
                       <button class="btn btn-default" type="button" 
                          v-on:click="excluir(item, index)">
                          <i class="fa fa-trash"></i>
                       </button>
                     </td>

                 </tr>
             </tbody>
             <tfoot >
              <tr v-if="items.length <= 0">
                <td colspan="3">
                  <i>Sem cadastro de {{titulo}}</i></td>
              </tr>
               <tr v-if="false" >
                <td colspan="3">
                 
                     <button class="btn btn-primary pull-right"
                             type="button"
                             v-on:click="salvar">Salvar</button>
                 </td>
              </tr>
             </tfoot>

         </table>


  </div>



</template>

<script>
    export default {
        props: {
                 recurso_id : {
                   type: Number,
                   default: function(){return null }

                 },
                 
                 tipo : {
                   type: String,
                   default: function(){return "rede_social" }

                 },
                 titulo : {
                   type: String,
                   default: function(){return "Contato" }

                 },
                  titulo_coluna_inicio : {
                   type: String,
                   default: function(){return "Link Rede Social" }

                 },
                 onSaveData:{
                     type: Function,
                     default: null
                 }

        } ,
        data: function() {
            return {
                
              items: [],
			  
			  
			  
              ids_excluir: [],

              action: "list",
              id: "",
              table: null,
              filtro_titulo: "",
              filtro_status: "",

              show_new_button: true,

              button_new_text: "" //<i class=\"fa fa-file\" ></i> NOVA POST"
            }
        },
        methods: {
            
            getIDItem(nome, index){
                return "recurso_cadastros_"+nome+"_L" +index.toString();
            },
            change_data_item(id_campo, value){



            },
            change_value(event){

              this.change_data_item( event.target.id, event.target.value );
              this.changeDataItens();

        
            },
            excluir(item, index){

                if (item.id != null &&  item.id != ""){

                     this.ids_excluir.unshift(  item.id );
                }

                this.items.splice(index, 1);

                this.changeDataItens();
            },
            changeDataItens(){
                      var hd_json = JSON.stringify(this.items);
                      var ids_delete_json = JSON.stringify(this.ids_excluir);

                      if ( this.onSaveData != null ){
                        this.onSaveData(hd_json,  ids_delete_json);
                      }

            },
            datepicker_return(dateText, inst){
                         console.log("Cheguei aqui? ");
            },
            salvar(){
                      var self = this;
                      var hd_json = JSON.stringify(this.items);
                      var ids_delete_json = JSON.stringify(this.ids_excluir);


                      var url =  "recurso_cadastros"; 
                      var method = "POST";

                      var data = {
                             hd_json: hd_json,
                             ids_delete_json: ids_delete_json,

                             recurso_id: this.recurso_id,
                             tipo: this.tipo
                      };
           
                      var fn_return = function (retorno){

                                     self.items = retorno.data;

                                     if (retorno.success){
                                        obj_alert.show("Sucesso!",
                                           "recurso_cadastros salvo com sucesso",
                                           "success", null, 3000);
                                     }    
                      }

                      obj_api.call(url, method, data , fn_return);
            },
            add(){
                  this.items.push( this.getArrayItem() );
            },
            getArrayItem(){
                      var data = {
                        id: "", 
                        id_recurso: this.id_recurso,  
                        tipo: this.tipo,  
                        descrcicao: "",  
                        texto: ""
                      };
                      return data;
            }
            
        },
        mounted() {

                let self = this;

                var url =  "recurso_cadastros?recurso_id=" + this.recurso_id +"&tipo=" + this.tipo; // +
                var method = "GET";
                this.disableButton = true;

                var data = { recurso_id: this.recurso_id, tipo: this.tipo }

                
                var fn_return = function (retorno){

                                 self.items = retorno.data;
                                 self.disableButton = false;

                }

                obj_api.call(url, method, data , fn_return);

                
  
        }
    }
    </script>