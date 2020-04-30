<template>
  <div>
    

<div class="row">
		<div class="col-xs-12">
          <div class="col-xs-12">
            <a href="#!" v-on:click="open_form" v-if="action != 'form'" class="btn btn-primary btn-formulario">
              <i class="fa fa-plus"></i>	&nbsp;Novo
            </a>

             <a href="#!" v-on:click="onBack" v-if="action == 'form'" class="btn btn-default">
              <i class="fa fa-arrow-left"></i>	&nbsp;Voltar para lista
            </a>
          </div>
		</div>
	</div>

  <div v-bind:style="style_list()">

    <div style="padding-top: 10px">
    <div class="col-xs-10">
              <div class="form-group">
                <label>Filtrar</label>
                <input type="text" class="form-control"
                 v-model="filtro_titulo"
                 placeholder="Digite para pesquisar">
              </div>
          </div>
    <div class="col-xs-2" style="padding-top: 20px;">
      
                                <button class="btn btn-primary btn-lg pull-left"  v-on:click="reload_table_search" >Filtrar</button>
         <button class="btn btn-default btn-lg" v-if="show_new_button"  v-on:click="open_form" v-html="button_new_text"  style="display:none" >
                     </button>

    </div>  
</div>

    <div class="col-xs-12" >
 


   


<table id="table_data" class="table table-bordered table-striped display" style="width: 100%">
        <thead>
            <tr> 
                      <th>Título {{titulo_cadastro}} </th>  
                      <th>Objetivo</th>  
                      <th>Dimensão</th>  
                      <th>Recursos</th>  
                   
                      <th>Status</th>  
                <th></th>
            </tr>
        </thead>
       
    </table>
  </div>
</div>
   <div v-if="action =='form'" class="col-xs-12">
         <recurso_form  v-bind:id_load="id" 
          v-bind:onSave="onSave" :titulo_cadastro="titulo_cadastro"
          :show_back_button="true" v-bind:onBack="onBack"></recurso_form>
  </div>

</div>
</template>

<script>
    export default {
       props: {
         post_type:{
          type: String,
          default () {  return "iniciativa" }
        },
        titulo_cadastro:{
           type: String,
            default () {  return "Iniciativa" }
        }

       },

        data: function() {
            return {

              action: "list",
              id: null,
              table: null,
              filtro_titulo: "",
              filtro_status: "",

              show_new_button: true,

              button_new_text: "" //<i class=\"fa fa-file\" ></i> NOVA POST"
            }
        },
        methods: {


          onBack ( objPost ){
              //Clicou no back button.
              this.id = null; //Voltando para a lista
              this.action = "list";
          },

          open_form (){
                    this.id = null;
                    this.action = "form";

          },

          editar ( datarow ){

            this.id = datarow.id;
            this.action = "form";

                     console.log("Vue recebeu o javascript:" + datarow.id );
                   //  console.log( datarow );
          },
          onSave(ret, tipo){
                  this.refresh_table();

                  if ( tipo == "save"){
                      obj_alert.show("Sucesso!","Iniciativa salva com sucesso!","success", null, 2000);
                  }
          },

          refresh_table(){
                  //   if ( this.table != null ){
                  //     this.table.ajax.reload( null, false ); // user paging is not reset on reload
                  //   }
                     var page = this.table.page.info().page;
                     this.reload_table_search(page);
          },
          get_filtro(){

            var data = {
              tipo_recurso: this.post_type,
              minhas: 1,
              filtro: this.filtro_titulo
            }

            return data;

          },

           reload_table_search(page) {
              var self = this;
              self.loading = true;
              if (this.table != null) {
                var filtro = this.get_filtro();

                obj_api.call(
                  "recursos",
                  "GET",
                  filtro,
                  function(retorno) {
                    var dataSet = retorno.data;
                    console.log("reload? ", dataSet);

                    self.table.clear().draw();
                    self.table.rows.add(dataSet); // Add new data

                    if (page != null && page != undefined && page > 0) {
                      // self.table.displayStart = page; //fnPageChange(page, true); //this.table.displayStart
                      self.table.columns.adjust().draw(); // Redraw the DataTable
                    } else {
                      self.table.columns.adjust().draw();
                    }
                    self.loading = false;
                  }
                );
              }
            },

          reload_table_search_old(){

                 if ( this.table != null ){


                      var url = window.URL_API +"recurso?tipo_recurso="+ this.post_type;

                        this.table.ajax.url( url ); 


                      console.log(url);
                      console.log(this.table );
                      this.table.ajax.reload( ); 
                 }
                     
          },

          style_list(){
                if ( this.action == "form" ){
                  return "display:none";
                }
                return "";
              }
        },
        computed: {
              
        },
        mounted() {

           let self = this;

           self.button_new_text =  "<i class=\"fa fa-user\" ></i> CADASTRAR";

           var filtro = this.get_filtro();
         
             obj_api.call("recursos", "GET", filtro, function(
                    retorno
                  ) {
                    var dataSet = retorno.data;
                      //  console.log( retorno );

                      $(document).ready(function() {
          

                    console.log("URL: " + window.URL_API +"recurso" );
                    console.log("Type: " + self.type );

              var table = $('#table_data').DataTable( {
                                  //"dom" : "Bfrtip",
                                "pagingType": "full_numbers",
                                "language" : obj_datatable.getLanguage(),
                                "responsive": true,
                                "processing": true,
                                "lengthChange": false,
                                'searching'   : false,
                                
                               data: dataSet,

                              "columns": [
                                            { "data": "nome" },  
                                            { "data": "objetivo" },
                                            { "data": "nome_dimensao" }, 
                                            { "data": "recursos" }, 
                                              
                                            { "data": "status" },   
                                              { "data": "blnk" }
                                              ],
                                  "order": [[ 0, "desc" ]]
                                  
                                  /*
                                  	<a href="/sistema/mapa/recursos/possibilidade/Chave philips" class="btn btn-warning btn-sm" title="Buscar Sinergia">
							<span class="glyphicon glyphicon-heart" aria-hidden="true"></span>
						</a>
			        	<a href="/sistema/potencialidades/cadastro/2" class="btn btn-primary btn-sm" title="Editar">
							<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
						</a>
						
														<a onclick="showMessageConf('Ao inativar o recurso ele não estará mais disponível para fluxo. Deseja realmente inativá-lo?', '/sistema/potencialidades/inativar/2')" class="btn btn-danger btn-sm" title="Inativar">
									<span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                </a>
                  */
                                  
                                , "columnDefs": [ 
                                  
                                            {
                                                      render: function(data, type, row) {
                                                        return (
                                                          "<a href=\"#!\" class=\"btn btn-primary btn-sm\" title=\"Editar\">"+
                                                                "<span class=\"glyphicon glyphicon-pencil\" aria-hidden=\"true\"></span>"+
                                                              "</a>");
                                                      },
                                                      targets: 5
                                            } 
                                  ] 
                              } );

                              self.table = table;
                          
                              $('#table_data tbody').on( 'click', 'a', function () {
                                  var data = table.row( $(this).parents('tr') ).data();
                                  self.editar(data);
                                  //alert( data[0] +"'s salary is: "+ data[ 5 ] );
                              } );
                            });

                  });

                   

          }
     }
 
    </script>
