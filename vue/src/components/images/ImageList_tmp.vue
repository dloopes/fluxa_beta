<template>
	<div>
	<div v-bind:style="style_list()">

    <div style="padding-top: 10px">
    <div class="col-md-5">
              <div class="form-group">
                <label>Título</label>
                <input type="text" class="form-control"
                 v-model="filtro_titulo"
                 placeholder="Digite para pesquisar">
               
              </div>
          </div>
    <div class="col-md-4">
              <div class="form-group">
                <label>Status</label>
                <select class="form-control select2" style="width: 100%;" v-model="filtro_status">
                  <option value="">Tudo</option>
                  <option value="publish">Publicados</option>
                  <option value="draft">Rascunhos</option>
                  <option value="review">Revisão</option>
                  <option value="private">Privados</option>
                </select>
              </div>
          </div>
    <div class="col-md-3" style="padding-top: 20px">
    	             <button class="btn btn-primary btn-lg"  v-on:click="reload_table_search" >Filtrar</button>
    		 <button class="btn btn-default btn-lg"  v-on:click="open_form" v-html="button_new_text" >
                     </button>

    </div>  
</div>

    <div class="col-xs-12" >
 


   


<table id="table_data" class="table table-bordered table-striped display" style="width: 100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Autor</th>
                <th>Data</th>
                <th></th>
            </tr>
        </thead>
       
    </table>
	</div>
</div>
	<post v-if="action =='form'" v-bind:id_load="id" 
          v-bind:onSave="onSave" v-bind:post_type="type"
	show_back_button="true" v-bind:onBack="onBack"></post>
</div>
</template>

<script>
    export default {
        props: [ 'post_type'],

        data: function() {
            return {

              action: "list",
            	id: "",
            	table: null,
            	filtro_titulo: "",
            	filtro_status: "",
              type: this.getType(),

              button_new_text: "<i class=\"fa fa-file\" ></i>NOVO POST"
            }
        },
        methods: {

          getType(){
                if ( this.post_type != null && this.post_type != undefined )
                  return this.post_type;

                return "post";
          },

        	onBack ( objPost ){
              //Clicou no back button.
              this.id = ""; //Voltando para a lista
              this.action = "list";
        	},

        	open_form (){
                    this.id = "";
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

                 	    var url = window.URL_API +"postgrid?type="+this.type+"&title="+
		        		this.filtro_titulo+"&status="+this.filtro_status;

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

           if ( self.type == "page"){
              self.button_new_text = "<i class=\"fa fa-html5\" ></i> NOVA"
           }

                     $(document).ready(function() {
          

	                  console.log("URL: " + window.URL_API +"postgrid" );
                    console.log("Type: " + self.type );

					    var table = $('#table_data').DataTable( {
					    	    //"dom" : "Bfrtip",
							    "pagingType": "full_numbers",
							    "responsive": true,
							    "processing": true,
                                "lengthChange": false,
                                'searching'   : false,
							    //"serverSide": true,
					             "ajax": {
								      "url" : window.URL_API +"postgrid",
								      "type": "GET",
								      "data": { type: self.type, 
								             title: self.filter_title, status: self.filter_status				
								       }} , 

							"columns": [
					                    { "data": "id" },
					                    { "data": "title" },
					                    { "data": "author_name" },
					                    { "data": "data" },
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
