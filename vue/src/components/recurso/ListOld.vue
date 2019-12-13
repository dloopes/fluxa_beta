<template>
  <div>
  <div v-bind:style="style_list()">

    <div style="padding-top: 10px">
    <div class="col-md-9">
              <div class="form-group">
                <label>Filtrar</label>
                <input type="text" class="form-control"
                 v-model="filtro_titulo"
                 placeholder="Digite para pesquisar">
               
              </div>
          </div>
    <div class="col-md-3" style="padding-top: 20px">
                   <button class="btn btn-primary btn-lg"  v-on:click="reload_table_search" >Filtrar</button>
         <button class="btn btn-default btn-lg" v-if="show_new_button"  v-on:click="open_form" v-html="button_new_text" >
                     </button>

    </div>  
</div>

    <div class="col-xs-12" >
 


   


<table id="table_data" class="table table-bordered table-striped display" style="width: 100%">
        <thead>
            <tr>
                      <th>ID</th>  
      <th>Título da Iniciativa</th>  
      <th>Detalhes</th>  
      <th>tipo_recurso</th>  
      <th>Categoria</th>  
      <th>Status</th>  
      <th>tipo_fluxo</th>  
                <th></th>
            </tr>
        </thead>
       
    </table>
  </div>
</div>
   <div v-if="action =='form'" class="col-xs-12">
         <recurso_form  v-bind:id_load="id" 
          v-bind:onSave="onSave" 
          :show_back_button="true" v-bind:onBack="onBack"></recurso_form>
  </div>

</div>
</template>

<script>
    export default {

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
          onSave(){
                  this.refresh_table();
          },

          refresh_table(){
                     if ( this.table != null ){
                       this.table.ajax.reload( null, false ); // user paging is not reset on reload
                     }
          },

          reload_table_search(){

                 if ( this.table != null ){

                      var url = window.URL_API +"recurso?filtro="+ this.filtro_titulo;

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
                  //"serverSide": true,
                       "ajax": {
                      "url" : window.URL_API +"recurso",
                      "type": "GET",
                      "data": {  
                             filtro: self.filter_title     
                       }} , 

              "columns": [
			                     { "data": "id" },  
   { "data": "nome" },  
   { "data": "detalhe" },  
   { "data": "tipo_recurso" },  
   { "data": "id_categoria" },  
   { "data": "status" },  
   { "data": "tipo_fluxo" },  
                              { "data": "blnk" }],
                  "order": [[ 0, "desc" ]]
                  
                  
                  /*, "columnDefs": [ {
                      "targets": 3,
                      "data": null,
                      "defaultContent": "<button>Click!</button>"
                  } 
                  ] */
              } );

              self.table = table;
           
              $('#table_data tbody').on( 'click', 'a', function () {
                  var data = table.row( $(this).parents('tr') ).data();
                  self.editar(data);
                  //alert( data[0] +"'s salary is: "+ data[ 5 ] );
              } );
            });

          }
     }
 
    </script>
