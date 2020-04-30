<template>
<div>

<section class="col-lg-12">
	<section class="col-lg-9" style="padding-left: 0px; margin-left: 0px">
      <h1 style="padding-left: 0px; margin-left: 0px">endereco

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

      
             <div class="md-layout">
                                <label class="md-layout-item md-size-15 md-form-label">
                                            cep
                                </label>
                                <div class="md-layout-item md-size-50">
                                            <md-field>
                                                     
              <md-input  name="cep"   type="text" placeholder="cep" v-model="form.cep" ></md-input>
								
                  
   

                                            </md-field>

                                          <span class="error_input">{{ getErrors('cep') }}</span>
                                </div>
             </div> 

             <div class="md-layout">
                                <label class="md-layout-item md-size-15 md-form-label">
                                            logradouro
                                </label>
                                <div class="md-layout-item md-size-50">
                                            <md-field>
                                                     
              <md-input  name="logradouro"   type="text" placeholder="logradouro" v-model="form.logradouro" ></md-input>
								
                  
   

                                            </md-field>

                                          <span class="error_input">{{ getErrors('logradouro') }}</span>
                                </div>
             </div> 

             <div class="md-layout">
                                <label class="md-layout-item md-size-15 md-form-label">
                                            numero
                                </label>
                                <div class="md-layout-item md-size-50">
                                            <md-field>
                                                     
              <md-input  name="numero"   type="text" placeholder="numero" v-model="form.numero" ></md-input>
								
                  
   

                                            </md-field>

                                          <span class="error_input">{{ getErrors('numero') }}</span>
                                </div>
             </div> 

             <div class="md-layout">
                                <label class="md-layout-item md-size-15 md-form-label">
                                            complemento
                                </label>
                                <div class="md-layout-item md-size-50">
                                            <md-field>
                                                     
              <md-input  name="complemento"   type="text" placeholder="complemento" v-model="form.complemento" ></md-input>
								
                  
   

                                            </md-field>

                                          <span class="error_input">{{ getErrors('complemento') }}</span>
                                </div>
             </div> 

             <div class="md-layout">
                                <label class="md-layout-item md-size-15 md-form-label">
                                            bairro
                                </label>
                                <div class="md-layout-item md-size-50">
                                            <md-field>
                                                     
              <md-input  name="bairro"   type="text" placeholder="bairro" v-model="form.bairro" ></md-input>
								
                  
   

                                            </md-field>

                                          <span class="error_input">{{ getErrors('bairro') }}</span>
                                </div>
             </div> 

             <div class="md-layout">
                                <label class="md-layout-item md-size-15 md-form-label">
                                            cidade
                                </label>
                                <div class="md-layout-item md-size-50">
                                            <md-field>
                                                     
              <md-input  name="cidade"   type="text" placeholder="cidade" v-model="form.cidade" ></md-input>
								
                  
   

                                            </md-field>

                                          <span class="error_input">{{ getErrors('cidade') }}</span>
                                </div>
             </div> 

             <div class="md-layout">
                                <label class="md-layout-item md-size-15 md-form-label">
                                            estado
                                </label>
                                <div class="md-layout-item md-size-50">
                                            <md-field>
                                                     
              <md-input  name="estado"   type="text" placeholder="estado" v-model="form.estado" ></md-input>
								
                  
   

                                            </md-field>

                                          <span class="error_input">{{ getErrors('estado') }}</span>
                                </div>
             </div> 

             <div class="md-layout">
                                <label class="md-layout-item md-size-15 md-form-label">
                                            pais
                                </label>
                                <div class="md-layout-item md-size-50">
                                            <md-field>
                                                     
              <md-input  name="pais"   type="text" placeholder="pais" v-model="form.pais" ></md-input>
								
                  
   

                                            </md-field>

                                          <span class="error_input">{{ getErrors('pais') }}</span>
                                </div>
             </div> 

             <div class="md-layout">
                                <label class="md-layout-item md-size-15 md-form-label">
                                            latitude
                                </label>
                                <div class="md-layout-item md-size-50">
                                            <md-field>
                                                     
                                                     <md-input  name="latitude" 
                                                           id="latitude" v-bind:value="form.latitude | show_numero_real"
                                                                type="text" placeholder="latitude" 
                                                                onkeypress="return obj_mask.Numerico(event, 2)"
                                                                style="width: 110px" /> 
									
									
									
			

                                            </md-field>

                                          <span class="error_input">{{ getErrors('latitude') }}</span>
                                </div>
             </div> 

             <div class="md-layout">
                                <label class="md-layout-item md-size-15 md-form-label">
                                            longitude
                                </label>
                                <div class="md-layout-item md-size-50">
                                            <md-field>
                                                     
                                                     <md-input  name="longitude" 
                                                           id="longitude" v-bind:value="form.longitude | show_numero_real"
                                                                type="text" placeholder="longitude" 
                                                                onkeypress="return obj_mask.Numerico(event, 2)"
                                                                style="width: 110px" /> 
									
									
									
			

                                            </md-field>

                                          <span class="error_input">{{ getErrors('longitude') }}</span>
                                </div>
             </div> 

             <div class="md-layout">
                                <label class="md-layout-item md-size-15 md-form-label">
                                            id_usuario
                                </label>
                                <div class="md-layout-item md-size-50">
                                            <md-field>
                                                     
				 
                 <md-input  name="id_usuario"   type="text" placeholder="id_usuario" v-model="form.id_usuario" ></md-input>
                 
				 
			
   

                                            </md-field>

                                          <span class="error_input">{{ getErrors('id_usuario') }}</span>
                                </div>
             </div> 

             <div class="md-layout">
                                <label class="md-layout-item md-size-15 md-form-label">
                                            id_recurso
                                </label>
                                <div class="md-layout-item md-size-50">
                                            <md-field>
                                                     
				 
                 <md-input  name="id_recurso"   type="text" placeholder="id_recurso" v-model="form.id_recurso" ></md-input>
                 
				 
			
   

                                            </md-field>

                                          <span class="error_input">{{ getErrors('id_recurso') }}</span>
                                </div>
             </div> 

             <div class="md-layout">
                                <label class="md-layout-item md-size-15 md-form-label">
                                            id_cidade
                                </label>
                                <div class="md-layout-item md-size-50">
                                            <md-field>
                                                     
				 
                 <md-input  name="id_cidade"   type="text" placeholder="id_cidade" v-model="form.id_cidade" ></md-input>
                 
				 
			
   

                                            </md-field>

                                          <span class="error_input">{{ getErrors('id_cidade') }}</span>
                                </div>
             </div> 

             <div class="md-layout">
                                <label class="md-layout-item md-size-15 md-form-label">
                                            id_estado
                                </label>
                                <div class="md-layout-item md-size-50">
                                            <md-field>
                                                     
				 
                 <md-input  name="id_estado"   type="text" placeholder="id_estado" v-model="form.id_estado" ></md-input>
                 
				 
			
   

                                            </md-field>

                                          <span class="error_input">{{ getErrors('id_estado') }}</span>
                                </div>
             </div> 
	  
 </div>

</div>
 </section>

  <section class="col-xs-12">
<!--

import EnderecoForm from './components/endereco/EnderecoForm'
import EnderecoList from './components/endereco/EnderecoList'


Vue.component('endereco_form', EnderecoForm);
Vue.component('endereco_list', EnderecoList );


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
              cep: "",  
              logradouro: "",  
              numero: "",  
              complemento: "",  
              bairro: "",  
              cidade: "",  
              estado: "",  
              pais: "",  
              latitude: "",  
              longitude: "",  
              id_usuario: "",  
              id_recurso: "",  
              id_cidade: "",  
              id_estado: "",  
				
            	disableButton: false,
            	publicar_titulo: "Salvar",
            	titulo_acao: "endereco",
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


                          var url =  "endereco/" + this.id_load; console.log("monted post url: " + url );
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
        self.cep = item.cep;   
        self.logradouro = item.logradouro;   
        self.numero = item.numero;   
        self.complemento = item.complemento;   
        self.bairro = item.bairro;   
        self.cidade = item.cidade;   
        self.estado = item.estado;   
        self.pais = item.pais;   
        self.latitude = item.latitude;   
        self.longitude = item.longitude;   
        self.id_usuario = item.id_usuario;   
        self.id_recurso = item.id_recurso;   
        self.id_cidade = item.id_cidade;   
        self.id_estado = item.id_estado;   
			   
		    },
		 
		 
            exibe_error( tipo ){
                    
            },

         	getClassFirstSection(){

         		if ( this.id != "")
         			return "col-xs-9";

         		return "col-xs-12";
         	},

         	validar(){
			
			             if ( obj_alert.isvazioInput("f_id","Informe o id!"))
                       	         return false;   
   if ( obj_alert.isvazioInput("f_cep","Informe o cep!"))
                       	         return false;   
   if ( obj_alert.isvazioInput("f_logradouro","Informe o logradouro!"))
                       	         return false;   
   if ( obj_alert.isvazioInput("f_numero","Informe o numero!"))
                       	         return false;   
   if ( obj_alert.isvazioInput("f_complemento","Informe o complemento!"))
                       	         return false;   
   if ( obj_alert.isvazioInput("f_bairro","Informe o bairro!"))
                       	         return false;   
   if ( obj_alert.isvazioInput("f_cidade","Informe o cidade!"))
                       	         return false;   
   if ( obj_alert.isvazioInput("f_estado","Informe o estado!"))
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
                var url =  "endereco"; console.log("url: " + window.URL_API + url );
                var method = "POST";

                if (this.id != null &&  this.id != ""){
                       method = "PUT"; url =  url + "/"+ this.id;
                }

                var data = {               id: this.id,  
              cep: this.cep,  
              logradouro: this.logradouro,  
              numero: this.numero,  
              complemento: this.complemento,  
              bairro: this.bairro,  
              cidade: this.cidade,  
              estado: this.estado,  
              pais: this.pais,  
  
                 latitude: obj_mask.getNumBr( $("#f_latitude").val() ) , 					
			 
  
                 longitude: obj_mask.getNumBr( $("#f_longitude").val() ) , 					
			 
              id_usuario: this.id_usuario,  
              id_recurso: this.id_recurso,  
              id_cidade: this.id_cidade,  
              id_estado: this.id_estado,   }


              var fn_return = function (retorno){
            
                  var item = retorno.item;
				  
				  self.carregaForm(item);

                  self.show_message = "on";
            	  self.message_text = "endereco salvo com sucesso!";

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
        		obj_api.call_delete("endereco", this.id, fn_return);
        	}
         }

    }


</script>
