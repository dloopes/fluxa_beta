<template>
  <div>
    
         <table class="table table-bordered table-striped">
           <tr>
               <td>
                 <input type="text" class="form-control" v-if="false"
                   id="tx_busca_recursos" placeholder="Digite para pesquisar" />

                      <vue_select class="vue-select2" name="sel_id_recurso" v-if="mostra_select"
                                            :options="items_recurso" v-model="id_recurso_filho"
                                            :searchable="true" language="pt-BR"  :onChange="loadRecurso"
                                            :placeholder="placeholder_recursos">
                                </vue_select>

               </td>
               <td>
                   
                     <button class="btn btn-primary"
                             type="button" :disabled="id_recurso_filho == null"
                             v-on:click="salvar">Adicionar</button>
               </td>

           </tr>
         </table>
         <table class="table table-bordered table-striped">
             <thead>
             	<tr>
                     
                           <th>Associação</th>  
                            <th>Tipo</th>  
                     <th style="width: 30px">
                       <button class="btn btn-default" v-if="false" v-on:click="add" type="button"
                       ><i class="fa fa-plus"></i></button>

                     </th>
             	</tr>
             </thead>
             <tbody>
                 <tr v-for="(item, index) in items" :key="index">
				   <td>  {{item.nome_recurso_filho}}			
			 </td> 
              <td>  
                     {{item.tipo_filho}}
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
                  <i>Sem associações</i></td>
              </tr>
               <tr v-if="false">
                <td colspan="11">
                 
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

import Util from '../../library/Util';

    export default {
        props: ['id_recurso_pai'],
        data: function() {
            return {
                
              items: [],
              items_recurso: [],
			  
			  
			  
              ids_excluir: [],
              mostra_select: true,

              action: "list",
              id: "",
              table: null,
              filtro_titulo: "",
              filtro_status: "",

              id_recurso_filho: null,
              nome_recurso_filho: "",
              show_new_button: true,
              disabled_add_button: true,

              button_new_text: "" ,//<i class=\"fa fa-file\" ></i> NOVA POST",
              placeholder_recursos: "carregando..",
            }
        },
        methods: {

          loadRecurso(val){


          },

           call_autocomplete(){
             var self = this;

             this.placeholder_recursos = "Carregando...";
             
             obj_api.call("recursos_busca", "get",
                                                    {
                                                    id_recurso_excluido: self.id_recurso_pai,
                                                    retorno: "array",
                                                    },function (retorno){

                                                                self.items_recurso = Util.getListToSelect( retorno.data, "id", "nome", null );
                                                                self.placeholder_recursos = "Digite para pesquisar";


                                                    });


             
                
              
                           /*  $("#tx_busca_recursos").autocomplete({
                                source: function(request, response){
                                                    obj_api.call("recursos_busca", "get",
                                                    {
                                                    term: request.term,
                                                    id_recurso_excluido: self.id_recurso_pai
                                                    },function (data){

                                                                            if(data.length > 0){
                                                                                  
                                                                                  //data = data.split(',');
                                                                                  response( $.each(data, function(key, item){
                                                                                    return({
                                                                                      label: item
                                                                                    });
                                                                                  }));
                                                                                }


                                                    });
                                  }, //obj_api.get_url("recursos_busca")+"?id_recurso_excluido=" + this.id_recurso_pai,
                                minLength: 3,
                                select: function (event, ui) {

                                    var frags = ui.item.label.split("|#|");
                                    console.log("frags? ", frags );
                                    $("#tx_busca_recursos").val(frags[0]);
                                    document.getElementById("tx_busca_recursos").value = frags[0];
                                    self.disabled_add_button = false;
                                    self.id_recurso_filho = frags[1];
                                    self.nome_recurso_filho = frags[0];

                                    // obj_header_busca.item_selecionado(ui.item.value, this);
                                }
                            }) .data("ui-autocomplete")._renderItem = function (ul, item) {

                                var frags = item.label.split("|#|");
                                //class=\"" + frags[2] + "\"

                                return $( "<li></li>" )
                                    .data( "item.autocomplete", item )
                                    .append("<a  href=\"#!\"><i ></i>" + frags[0] + "</a>")
                                    .appendTo( ul );
                            }; 

                            */
                            
            },
            
            excluir(item, index){

              var self = this;

              obj_alert.confirm("Atenção","Deseja realmente remover?", "question", function (question){
                             if ( question.value ){

                                     obj_api.call("recurso_associacao_grid/"+item.id,"delete", {}, function(retorno){
                                                 self.items.splice(index, 1);
                                     })
                             }
              });

              /*
              console.log("Excluir? ");

                if (item.id != null &&  item.id != ""){

                     this.ids_excluir.unshift(  item.id );
                }

                this.items.splice(index, 1);
                */
            },
            datepicker_return(dateText, inst){
                         console.log("Cheguei aqui? ");
            },
            salvar(){
                      var self = this;
                      self.mostra_select = false;

                      var data = {id_recurso_pai: this.id_recurso_pai,
                                  id_recurso_filho: this.id_recurso_filho,
                                  tipo: "cadastro" }

                      obj_api.call("recurso_associacao_grid", "post", data, function(retorno){
                                   
                                 self.items = retorno.data;
                                 self.id_recurso_filho = null;
                                 self.mostra_select = true;
                      });            

                      /*
                      var hd_json = JSON.stringify(this.items);
                      var ids_delete_json = JSON.stringify(this.ids_excluir);


                      var url =  "recurso_associacao/salvargrid"; 
                      var method = "POST";

                      var data = {
                             hd_json: hd_json,
                             ids_delete_json: ids_delete_json,

                            // equipamento_id: this.equipamento_id,
                            // projeto_id: this.projeto_id
                      };
           
                      var fn_return = function (retorno){

                                     self.items = retorno.data;

                                     if (retorno.success){
                                        obj_alert.show("Sucesso!",
                                           "recurso_associacao salvo com sucesso",
                                           "success", null, 3000);
                                     }    
                      }

                      obj_api.call(url, method, data , fn_return);
                      */
            },
            add(){
                  this.items.push( this.getArrayItem() );
            },
            getArrayItem(){
                      var data = {
						              id: null,  
                                        id_recurso_pai: this.id_recurso_pai,  
                                        id_usuario_recurso_pai: "",  
                                        id_recurso_filho: "",  
                                        id_usuario_recurso_filho: "",  
                                        tipo: "",  
                                        status: "",  
                                        date_insert: "",  
                      };

                       // if ( this.equipamento_id != null ){
                       //        data["equipamento_id"] = this.equipamento_id;

                       // } 
                       // if ( this.projeto_id != null ){
                       //        data["projeto_id"] = this.projeto_id;

                       // } 


                      return data;
            }
            
        },
        mounted() {

                let self = this;

               console.log("chamando autocomplete?");
                this.call_autocomplete();



                var url =  "recurso_associacao_grid"; // +
                // this.id_load; console.log("monted post url: " + url );
                var method = "GET";
                this.disableButton = true;

                var data = { id_recurso_pai: this.id_recurso_pai , tipo: "cadastro"}
                
                var fn_return = function (retorno){

                                 self.items = retorno.data;
                                 self.disableButton = false;

                }

                obj_api.call(url, method, data , fn_return);



                
  
        }
    }
    </script>