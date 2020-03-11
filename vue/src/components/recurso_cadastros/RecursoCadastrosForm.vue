<template>
<div>

<section class="col-lg-12">
	<section class="col-lg-9" style="padding-left: 0px; margin-left: 0px">
      <h1 style="padding-left: 0px; margin-left: 0px">recurso_cadastros

      </h1>
      <ol class="breadcrumb" style="display: none">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Forms</a></li>
        <li class="active">General Elements</li>
      </ol>
    </section>

<section class="col-lg-3" style="padding-top: 30px">
        <a href="#"  v-on:click="botao_voltar" v-if="botao_voltar_visible">
           <i class="fa fa-arrow-left"></i> Voltar para lista
        </a> 
</section>
</section>

<div class="col-lg-12">
					<div v-if="show_message == 'on' " class="alert alert-success">
					      {{message_text}}
					</div>
</div>


<section class="col-xs-12">
<div class="box"><div class="box-header with-border"></div> 
<div class="box-body">

       <div class="form-group">  
				 
				 	
								  <label for="f_id_recurso">id_recurso</label>
								   <input class="form-control" name="f_id_recurso" 
									 id="f_id_recurso" v-model="id_recurso"
							  type="text" placeholder="id_recurso" > {{exibe_error('id_recurso')}}
                 
				 
			
    </div> 
 <div class="form-group">  
								  <label for="f_tipo">Tipo</label>
								   <input class="form-control" name="f_tipo" 
									 id="f_tipo" v-model="tipo"
							  type="text" placeholder="Tipo" > {{exibe_error('tipo')}}
                  
    </div> 
 <div class="form-group">  
								  <label for="f_descrcicao">Descrição</label>
								   <input class="form-control" name="f_descrcicao" 
									 id="f_descrcicao" v-model="descrcicao"
							  type="text" placeholder="Descrição" > {{exibe_error('descrcicao')}}
                  
    </div> 
 <div class="form-group">  
								  <label for="f_texto">Detalhes</label>
								   <input class="form-control" name="f_texto" 
									 id="f_texto" v-model="texto"
							  type="text" placeholder="Detalhes" > {{exibe_error('texto')}}
                  
    </div> 
	  
 </div>

</div>
 </section>

  <section class="col-xs-12">
<!--

import RecursoCadastrosForm from './components/recurso_cadastros/RecursoCadastrosForm'
import RecursoCadastrosList from './components/recurso_cadastros/RecursoCadastrosList'


Vue.component('recurso_cadastros_form', RecursoCadastrosForm);
Vue.component('recurso_cadastros_list', RecursoCadastrosList );


-->


 <div class="form-group">
                	<div class="btn-group pull-right" >


                     <button type="submit" class="btn btn-info" 
                      v-bind:disabled="disableButton"
                     v-on:click="salvar()">{{publicar_titulo}}</button> 


                     <button type="submit" class="btn btn-danger" 
                      v-bind:disabled="disableButton" v-if="id!='' && parseInt(id) > 0"
                     v-on:click="excluir()">Excluir</button> 
                 </div> 
             </div>

  </section>

</div>
</template>

<script>
    export default {
      props: ['id_load', 'post_type', 'show_back_button','onBack', 'onSave'],
       data: function() {
            return {
            	
				              id: "",  
              id_recurso: "",  
              tipo: "",  
              descrcicao: "",  
              texto: "",  
				
            	disableButton: false,
            	publicar_titulo: "Salvar",
            	titulo_acao: "recurso_cadastros",
            	botao_voltar_visible: false,

            	show_message: "off",
            	message_text: "",
            	message_type: "success",
            	interval_message: null,


            }
        },
        mounted() {

                let self = this;
   
                            if ( this.show_back_button != null && this.show_back_button != undefined  ){
                                     this.botao_voltar_visible = this.show_back_button;
                            }


                          if ( this.id_load == null || this.id_load == ""){
                            return;
                          }


                          var url =  "recurso_cadastros/" + this.id_load; console.log("monted post url: " + url );
                          var method = "get";

                          this.disableButton = true;

                          var data = { }


			              var fn_return = function (retorno){

                                           // console.log("Retorno? ");
                                           // console.log( retorno );
                                            
			              	     var item = retorno.item;
								 
								 self.carregaForm(item);



                                 self.disableButton = false;

			              }

			              obj_api.call(url, method, data , fn_return);



         },
         methods:{
		 
		 
            carregaForm(item){
                     var self = this;
			                 self.id = item.id;   
        self.id_recurso = item.id_recurso;   
        self.tipo = item.tipo;   
        self.descrcicao = item.descrcicao;   
        self.texto = item.texto;   
			   
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

             
                    	return true;
         	},


        	botao_voltar(){
        		var self = this;

                 if ( this.onBack != null && this.onBack != undefined ){
                 	console.log("clique no voltar!");
                 	 this.onBack( self );
                 }
        	},

        	salvar (tipo ){

        		if ( !this.validar() )
        			return false;

        	
                let self = this;
                var url =  "recurso_cadastros"; console.log("url: " + window.URL_API + url );
                var method = "POST";

                if (this.id != null &&  this.id != ""){
                       method = "PUT"; url =  url + "/"+ this.id;
                }

                var data = {               id: this.id,  
              id_recurso: this.id_recurso,  
              tipo: this.tipo,  
              descrcicao: this.descrcicao,  
              texto: this.texto,   }


              var fn_return = function (retorno){
            
                  var item = retorno.item;
				  
				  self.carregaForm(item);

                  self.show_message = "on";
            	  self.message_text = "recurso_cadastros salvo com sucesso!";

            	  self.interval_message = setInterval(self.clear_message, 6000);

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
        		var fn_return = function(retorno, tipo){
        			self.onSave(retorno, tipo);
        			self.botao_voltar();

        		}
        		obj_api.call_delete("recurso_cadastros", this.id, fn_return);
        	}
         }

    }


</script>
