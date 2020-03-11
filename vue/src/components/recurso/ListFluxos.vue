<template>
  <div>
    


  <div v-bind:style="style_list()">


    <div class="col-xs-12" >
 <div class="box">
<div class="box-body table-responsive no-padding">
<table id="table_data_fluxos" class="table table-bordered table-striped display" style="width: 100%">
        <thead>
            <tr> 
                      <th>Data </th>  
                      <th>Fluxo</th>  
                      <th>Status</th>    
                <th></th>
            </tr>
        </thead>
       
    </table>
  </div>
  </div>

  </div>
</div>

</div>
</template>

<script>
import Util from '../../library/Util';

    export default {
       props: {
         post_type:{
          type: String,
          default () {  return "iniciativa" }
        },
        titulo_cadastro:{
           type: String,
            default () {  return "Iniciativa" }
        },
        id_form:{
            type: Number,
            default(){ return null }
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

          },
          onSave(){
                  this.refresh_table();
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
              id_recurso: this.id_form
            }

            return data;

          },

           reload_table_search(page) {
              var self = this;
              self.loading = true;
              if (this.table != null) {
                var filtro = this.get_filtro();

                obj_api.call(
                  "fluxo_list",
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
              },
          openModal(item){
              var url = window.K_URL_SISTEMA + "/fluxo/" + item.id+"?clean=1";

                        $.colorbox({innerWidth: 800, height: 450, iframe:true, href: url });
                         //   $(".iframe_short_modal").colorbox({iframe:true, innerWidth: 800, height: 450});


            },
        },
        computed: {
              
        },
        mounted() {

           let self = this;

           self.button_new_text =  "<i class=\"fa fa-user\" ></i> CADASTRAR";

           var filtro = this.get_filtro();
         
             obj_api.call("fluxo_list", "GET", filtro, function(
                    retorno
                  ) {
                    var dataSet = retorno.data;
                      console.log( "fluxo_list",  retorno );

                      $(document).ready(function() {
          

              var table = $('#table_data_fluxos').DataTable( {
                                  //"dom" : "Bfrtip",
                                "pagingType": "full_numbers",
                                "language" : obj_datatable.getLanguage(),
                                "responsive": true,
                                "processing": true,
                                "lengthChange": false,
                                'searching'   : false,
                                
                               data: dataSet,

                              "columns": [
                                            { "data": "data" },  
                                            { "data": "descricao" },
                                            { "data": "status" },  
                                              { "data": "blnk" }
                                              ],
                                  "order": [[ 0, "desc" ]]
                                  
                             
                                  
                                , "columnDefs": [ 
                                             {
                                                      render: function(data, type, row) {
                                                        return (
                                                          "<span style='display:none'>" + data +"</span>" +  Util.ApiDateToBR( data ));
                                                      },
                                                      targets: 0
                                            } ,
                                  
                                            {
                                              //href=\"http://localhost:8080/diogo_loopes/fluxa_beta/fluxo/"+row.id+"\" 
                                                      render: function(data, type, row) {
                                                        return (
                                                          "<a  class=\"btn btn-primary btn-sm\" title=\"Editar\">"+
                                                                "<span class=\"glyphicon glyphicon-eye-open\" aria-hidden=\"true\"></span>"+
                                                              "</a>");
                                                      },
                                                      targets: 3
                                            } 
                                  ] 
                              } );

                              self.table = table;
                          
                              $('#table_data_fluxos tbody').on( 'click', 'a', function () {
                                  var data = table.row( $(this).parents('tr') ).data();
                                  self.openModal(data);
                                  //alert( data[0] +"'s salary is: "+ data[ 5 ] );
                              } );
                            });

                  });

                   

          }
     }
 
    </script>
