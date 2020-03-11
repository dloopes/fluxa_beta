<template>
  <div>


<table id="table_lista_servico_cons" class="table table-bordered table-striped display" style="width: 100%">
        <thead>
            <tr>
                      <th>ID</th>  
      <th>id_recurso</th>  
      <th>Tipo</th>  
      <th>Descrição</th>  
      <th>Detalhes</th>  
            </tr>
        </thead>
       
    </table>


  </div>
</template>

<script>
    export default {
         // props: ['equipamento_id', 'projeto_id'],
        data: function() {
            return {

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


          refresh_table(){
                     if ( this.table != null ){
                       this.table.ajax.reload( null, false ); // user paging is not reset on reload
                     }
          },

          reload_table_search(){

                 if ( this.table != null ){

                      var url = window.URL_API +"recurso_cadastros?filtro=";

                     // if ( this.equipamento_id != null ){
                     //   url += "&equipamento_id=" + this.equipamento_id;
                     // }

                     //   if ( this.projeto_id != null  ){
                     //   url += "&projeto_id=" + this.projeto_id;
                     // }

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


                     $(document).ready(function() {

                      var url = window.URL_API +"recurso_cadastros?filtro=";

                      //if ( this.equipamento_id != null ){
                      //  url += "&equipamento_id=" + this.equipamento_id;
                     // }

                     //   if ( this.projeto_id != null  ){
                     //   url += "&projeto_id=" + this.projeto_id;
                     // }
                      var data_filtro = {};

              var table = $('#table_lista_servico_cons').DataTable( {
                                  //"dom" : "Bfrtip",
                                "pagingType": "full_numbers",
                                "language" : obj_datatable.getLanguage(),
                                "responsive": true,
                                "processing": true,
                                "lengthChange": false,
                                'searching'   : false,
                  //"serverSide": true,
                       "ajax": {
                      "url" : url,
                      "type": "GET",
                      "data": data_filtro } , 

              "columns": [
			                     { "data": "id" },  
   { "data": "id_recurso" },  
   { "data": "tipo" },  
   { "data": "descrcicao" },  
   { "data": "texto" },  
                           ],
                  "order": [[ 0, "asc" ]]
                
              } );

              self.table = table;
           
		      /*
              $('#table_projeto tbody').on( 'click', 'a', function () {
                  var data = table.row( $(this).parents('tr') ).data();
                  self.editar(data);
                  //alert( data[0] +"'s salary is: "+ data[ 5 ] );
              } ); */
            });

          }
     }
 
    </script>
