<template>
<div>

<section class="col-xs-12" v-if="false" >
	<section class="col-xs-9" style="padding-left: 0px; margin-left: 0px">
      <h3 style="padding-left: 0px; margin-left: 0px">Cadastro {{titulo_cadastro}}

      </h3>
      <ol class="breadcrumb" style="display: none">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Forms</a></li>
        <li class="active">General Elements</li>
      </ol>
    </section>

<section class="col-xs-3" style="padding-top: 30px">
        <a href="#"  v-on:click="botao_voltar" v-if="botao_voltar_visible">
           <i class="fa fa-arrow-left"></i> Voltar para lista
        </a> 
</section>
</section>

<div class="col-xs-12">
					<div v-if="show_message == 'on' " class="alert alert-success">
					      {{message_text}}
					</div>
</div>


<section class="col-xs-12" style="margin-top: 10px">
<div class="box">
<div class="box-body">






      <div class="col-xs-12">
       <div class="form-group">  
								  <label for="f_nome">Título da Iniciativa</label>
								   <input class="form-control" name="f_nome" 
									 id="f_nome" v-model="form.nome"
							  type="text" placeholder="Título da Iniciativa" > 
                  
       </div>     
     </div> 



      <div class="col-xs-8">

             <div class="form-group" v-if="post_type=='iniciativa' ">  
                              
                                <label for="f_detalhe" >Objetivo</label>
                                   <input class="form-control" name="f_nome" 
                                                      id="f_detalhe" v-model="form.dados.objetivo"
                                                    type="text" placeholder="Objetivo da iniciativa" >
                                            <textarea class="form-control" v-model="form.dados.objetivo" name="f_dados_objetivo" 
                     id="f_dados_objetivo"  style="height: 200px" v-if="false"></textarea> 
                             </div>  
                          
          </div> 

            <div class="col-xs-4">
                     


                                  <div class="form-group">  
                             
                              
                                      <label for="f_status">Status</label>
                                       <select class="form-control" name="f_status" 
                                       id="f_status" v-model="form.status">
                                       <option :value="item.id" v-for="(item, index) in list_status" :key="index">{{item.nome}}</option>


                                      </select>
                             
                          
                        </div>    
        </div> 


 <div class="form-group" v-if="false">  
			
			  <label for="f_detalhe" >Detalhes</label>
                  
                   <textarea class="form-control" v-model="form.detalhe" name="f_detalhe" 
                     id="f_detalhe"  style="height: 400px"></textarea> 
					  {{exibe_error('detalhe')}}
		 </div> 



      <div class="col-xs-6">

                                   <div class="form-group">  
                                   
                                    
                                            <label for="f_id_categoria">Categoria</label>

                                 <input class="form-control" v-if="false" name="f_categoria" 
                                              id="f_categoria" v-model="form.dados.categoria"
                                         type="text" placeholder="Categoria (separe por vírgula) " > 

                                           
                     <checkboxlist v-model="form.dados.categoria"  :lista="lista_cat"  name="f_categoria" 
                           id="f_categoria"  /> 
                                   
                                
                              </div> 
       
                
    </div> 

       <div class="col-xs-6">
           <div class="form-group" v-if="post_type=='iniciativa' ">  
            
              <label for="f_detalhe" >ODS: Objetivos de Desenvolvimento Sustentável</label>

                     <checkboxlist v-model="form.dados.objetivo_ods"  :lista="lista_ods"  name="f_dados_objetivo_ods" 
                           id="f_dados_objetivo_ods"  /> 

           </div> 

      </div> 

       <div class="col-xs-4">
                  <div class="form-group">  
                              <label for="f_dimensao">Dimensão </label>
                                <select class="form-control" name="f_id_categoria" 
                                             id="f_id_categoria" v-model="form.id_categoria">
                                             <option :value="item.id" v-for="(item, index) in list_categorias" :key="index">{{item.nome}}</option>


                                            </select>

                          
                              
                  </div> 
       </div> 

       <div class="col-xs-8">
                 <div class="form-group">  
                                  <label for="f_recursos">Recursos</label>
                                   <input class="form-control" name="f_recursos" 
                                   id="f_recursos" v-model="form.dados.recursos"
                                type="text" placeholder="Recursos" > {{exibe_error('recursos')}}
                                  
                    </div> 
         </div> 

       <div class="col-xs-12" v-if="form.id != null && parseInt(form.id) > 0 && show_contato">
                 <div class="form-group">  

                        <recurso_cadastros_list_cadtable
                            :id_recurso="form.id" titulo="de Forma de Contato" tipo="contato"
                            titulo_coluna_inicio="Link Rede Social ou Contato" :recurso_id="form.id" :onSaveData="saveDataCadastros"
                            ></recurso_cadastros_list_cadtable>
          </div> 
         </div> 

 <div class="form-group" v-if="false">  
								  <label for="f_tipo_recurso">tipo_recurso</label>
								   <input class="form-control" name="f_tipo_recurso" 
									 id="f_tipo_recurso" v-model="form.tipo_recurso"
							  type="text" placeholder="tipo_recurso" > 
                  
    </div> 



 <div class="form-group" v-if="false">  
								  <label for="f_tipo_fluxo">tipo_fluxo</label>
								   <input class="form-control" name="f_tipo_fluxo" 
									 id="f_tipo_fluxo" v-model="form.tipo_fluxo"
							  type="text" placeholder="tipo_fluxo" > {{exibe_error('tipo_fluxo')}}
                  
    </div> 
	  
 </div>

</div>
 </section>

 
  

  <section class="col-xs-12">
<!--

import RecursoForm from './components/recurso/RecursoForm'
import RecursoList from './components/recurso/RecursoList'


Vue.component('recurso_form', RecursoForm);
Vue.component('recurso_list', RecursoList );


-->


 <div class="form-group">
                	<div class="btn-group pull-right" >


                     <button type="submit" class="btn btn-info" 
                      v-bind:disabled="disableButton"
                     v-on:click="salvar">{{publicar_titulo}}</button> 


                     <button type="submit" class="btn btn-danger" 
                      v-bind:disabled="disableButton" v-if="form.id!=null && parseInt(form.id) > 0"
                     v-on:click="excluir">Excluir</button> 
                 </div> 
             </div>

  </section>

<section class="col-xs-12" style="margin-top: 10px" v-if="form.id != null && parseInt(form.id) > 0 ">
<div class="box"><div class="box-header with-border">Potencialidades e Possibilidades</div> 
<div class="box-body">

    <recurso_associacao
        :id_recurso_pai="form.id"
         ></recurso_associacao>

</div>
</div>
</section>
<section class="col-xs-12" style="margin-top: 10px" v-if="form.id != null && parseInt(form.id) > 0 ">
<div class="box"><div class="box-header with-border">Upload de arquivos</div> 
<div class="box-body">

    <upload-folder
        :id_registro="form.id"
        id_tabela="recurso" ></upload-folder>

</div>
</div>
</section>


 

</div>
</template>

<script>

import checkboxlist from '../geral/checkboxlist.vue';
import recurso_cadastros_list_cadtable from '../recurso_cadastros/RecursoCadastrosListCadTable.vue'

    export default {
      components: {
        checkboxlist,
        recurso_cadastros_list_cadtable
      },
      props: {

        id_load:{
          type: Number,
          default () {  return null }
        },
         post_type:{
          type: String,
          default () {  return "iniciativa" }
        },
          show_back_button:{
          type: Boolean,
          default () {  return false }
        },
        onSave:{
          type: Function,
          default () {  return null }
        },
        onBack:{
          type: Function,
          default () {  return null }
        }
        ,
        titulo_cadastro:{
           type: String,
            default () {  return "Iniciativa" }
        }


        } ,
       data: function() {
            return {

              form:{

                      id: null,  
                      nome: "",  
                      detalhe: "",  
                      tipo_recurso: "",  
                      id_categoria: "",  
                      status: "",  
                      tipo_fluxo: "", 
                      dados: {
                                id: "",  
                                objetivo: "",  
                                objetivo_ods: "",  
                                dimensao: "",  
                                recursos: "", 
                                categoria: "",
                      }


              },

              show_contato: true,

              list_categorias: [],
              list_status: [],
              lista_ods: [],
              lista_cat: [],

              
              hd_json:"[]",
              ids_delete_json:"[]",
            	
				             
        				
                    	disableButton: false,
                    	publicar_titulo: "Salvar",
                    	titulo_acao: "Recurso",
                    	botao_voltar_visible: false,

                    	show_message: "off",
                    	message_text: "",
                    	message_type: "success",
                    	interval_message: null,


            }
        },
        mounted() {

                this.form.tipo_fluxo = this.post_type;

                let self = this;
   
                            if ( this.show_back_button != null && this.show_back_button != undefined  ){
                                     this.botao_voltar_visible = this.show_back_button;
                            }


                         obj_api.call("recursos_new", "GET", {} , function(response){
                              self.list_categorias = response.list_categorias;
                              self.list_status = response.list_status;
                              self.lista_ods = response.lista_ods;
                              self.lista_cat = response.lista_cat;
                         });

                          if ( this.id_load == null || this.id_load.toString() == ""){
                            return;
                          }


                          var url =  "recursos/" + this.id_load; console.log("monted post url: " + url );
                          var method = "get";

                          this.disableButton = true;

                          var data = { }


			              var fn_return = function (retorno){
                  
                           self.form = retorno.item;
                           
                           if ( self.form.dados == null || self.form.dados == undefined ){
                                     self.form.dados = {
                                                  id: "",  
                                                            objetivo: "",  
                                                            objetivo_ods: "",  
                                                            dimensao: "",  
                                                            recursos: "", 
                                                  }
                           }
                           self.disableButton = false;

			              }

			              obj_api.call(url, method, data , fn_return);



         },
         methods:{
		 
		 
            carregaForm(item){
                     var self = this;
			                 self.id = item.id;   
                      self.nome = item.nome;   
                      self.detalhe = item.detalhe;   
                      self.tipo_recurso = item.tipo_recurso;   
                      self.id_categoria = item.id_categoria;   
                      self.status = item.status;   
                      self.tipo_fluxo = item.tipo_fluxo;   
			   
		    },
		 
		 
            exibe_error( tipo ){
                    
            },

         	getClassFirstSection(){

         		if ( this.id != "")
         			return "col-xs-9";

         		return "col-xs-12";
         	},

         	validar(){
			
			             if ( obj_alert.isvazioInput("f_id","Informe o ID!"))
                       	         return false;   
                   if ( obj_alert.isvazioInput("f_nome","Informe o Título da Iniciativa!"))
                                       	         return false;   
                   if ( obj_alert.isvazioInput("f_tipo_recurso","Informe o tipo_recurso!"))
                                       	         return false;   

             
                    	return true;
         	},


        	botao_voltar(){
        		var self = this;

                 if ( this.onBack != null && this.onBack != undefined ){
                 	console.log("clique no voltar!");
                 	 this.onBack( self );
                 }
          },
          
          saveDataCadastros( hd_json,  ids_delete_json ){
                         this.hd_json = hd_json;
                         this.ids_delete_json = ids_delete_json;
          },

        	salvar (tipo ){

        		if ( !this.validar() )
        			return false;

        	
                let self = this;
                var url =  "recursos"; console.log("url: " + window.URL_API + url );
                var method = "POST";

                if (this.form.id != null &&  this.form.id.toString() != ""){
                       method = "POST"; url =   "recursos_edit/"+ this.form.id;
                }

                self.disableButton = true;
                self.show_contato = false;

                  var data = {               
                              id: this.form.id,  
                              nome: this.form.nome,  
                              detalhe: this.form.detalhe,  
                              tipo_recurso: this.post_type,  
                              id_categoria: this.form.id_categoria,  
                              status: this.form.status,  
                              tipo_fluxo: this.form.tipo_fluxo   ,
                              categoria: this.form.dados.categoria,
                              //dimensao: this.form.dados.dimensao,
                              objetivo: this.form.dados.objetivo,
                              objetivo_ods: this.form.dados.objetivo_ods,
                              recursos: this.form.dados.recursos
                              }

                if (this.form.id != null &&  this.form.id.toString() != ""){
                  data["hd_json"] = this.hd_json;
                  data["ids_delete_json"] = this.ids_delete_json;
                  data["recurso_id"] = this.form.id;
                }

               // var data = this.form;


               var fn_return = function (retorno){
                    
                      var item = retorno.item;
                  
                       self.form = item;
                      //self.carregaForm(item);

                      self.show_message = "on";
                      self.message_text = " Iniciativa salva com sucesso!";
                      self.interval_message = setTimeout(self.clear_message, 6000);
                      self.disableButton = false;
                      self.show_contato = true;

                     if ( self.onSave != null && self.onSave != undefined ){
                            self.onSave(retorno, 'save');
                     }



              }

              obj_api.call(url, method, data , fn_return);

        	},

        	clear_message(){
                 this.show_message = "off";
                 clearInterval(this.interval_message);
        	},

        	excluir(){
        		let self = this;

            obj_alert.confirm("Atenção","Deseja realmente excluir esta " + this.titulo_cadastro+"?","question", function(question){

              if ( question.value ){
                              

                          var fn_return = function(retorno, tipo){
                            self.onSave(retorno, tipo);
                            self.botao_voltar();

                          }
                          obj_api.call_delete("recursos", this.form.id, fn_return);
              }



              
            })


        	}
         }

    }


</script>
