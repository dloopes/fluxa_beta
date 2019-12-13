<template>
     <div v-bind:class="getClass('box')">
 
            <div v-bind:class="getClass('box-header with-border')" >
                     <label  class="box-title">{{title}}</label>
            </div>
             <div v-bind:class="getClass('box-body')">
                <center>
	                      <img v-bind:src="url" 
						     v-if="id > 0"
						   style="max-height: 60px; max-width: 96%" />
                </center>

						   <upload v-if="getVisibleFile()" v-bind:ptype="ptype" v-bind:p_parentid="id_parent" show_drop="0" v-bind:onSave="onSave">

						   </upload>
					
            </div>

  </div>
</template>

<script>
    export default {
        props: [ 'ptype', 'id_parent', 'title', 'com_classes', 'habilita_edicao' ],

        data: function() {
            return {             
                id: 0,
                imagem: "",
                url: "",
                habilitado: true
            }
        },
         mounted() {

          if ( this.habilita_edicao != null && this.habilita_edicao != undefined ){
                   this.habilitado = this.habilita_edicao == "1";
          }

         	//console.log("upload único: "); console.log(this.id_parent);

         	if ( this.id_parent == null || this.id_parent == undefined || this.id_parent == "0" || this.id_parent == "")
         		return;

        	let self = this;

             var url =  window.URL_API +"midiaparent/" + this.id_parent+"/"+this.ptype;
              console.log("upload único monted post url: " + url );

                          var data = new FormData();
               
                          $.ajax({
                                  type: "GET",
                                  url: url,
                                  contentType: false,
                                  processData: false,
                                  data: data,
                                  success: function (retorno) {

                                    console.log("Carregando dados uploadunico");
                                    console.log(retorno);


                                  	if ( retorno.length > 0 ){
                                     var item = retorno[0];

	                                    self.id = parseInt(item.id);
	                                    self.url = item.url;
                                                self.imagem = item.filename;
                                            if ( item.filename.indexOf(".zip") > -1 ){
                                                self.url = item.thumbnail;
                                                
                                            }else{
                                            }

                                  	}

                                
                                      //self.loadcategories( retorno.categories );
                                      //self.items = retorno;
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
        methods:{
                   getClass(txt){

                    if ( this.com_classes == null || this.com_classes == undefined ){
                        return txt;
                    }

                    if ( this.com_classes == "0"){
                      return "";
                    }

                    return txt;

                     //box  box-header box-body
                   },


                   onSave(retorno, tipo){

                            console.log("On Saved: "  ); console.log(retorno);

                                  	if ( retorno.length > 0 ){
                                     var item = retorno[0];

	                                    this.id = parseInt(item.id);
	                                    this.url = item.url;
	                                    this.imagem = item.filename;

                                  	}

                   },

                   getVisibleFile(){

                     if ( this.habilita_edicao != null && this.habilita_edicao != undefined ){
                                return this.habilita_edicao == "1";
                        }

                        return true;
                   }

        	}
 }

</script>