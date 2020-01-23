<template>
  <div>
     <div  class="col-xs-12" >

        <div :class="getEstilo('box')" >
         <div :class="getEstilo('box-body')">

        <h5 v-html="titulo"></h5>
        <button
          class="md-default"
          v-if="show_botao_upload"
          v-on:click="botao_mostra_upload"
        >Adicionar Arquivos</button>

        <upload :p_parentid="id_registro" :ptype="id_tabela" v-bind:onSave="onSave"  v-if="show_botao_upload"></upload>

        <div class="md-layout" v-if="loading">
          <div class="md-layout-item md-size-100">
             {{msg_status}} ..
           
          </div>
        </div>
        <div class="col-xs-12">
          <div v-for="(item, index) in items " :key="index" :class="'col-xs-' + (tamanho_coluna != null && tamanho_coluna != undefined ? tamanho_coluna.toString() : '3') ">
            <div v-if="item.type.indexOf('image') > -1 ">
              <img v-bind:src="item.url_thumb" style="max-height: 70px; max-width: 70px; " />
            </div>
            <div v-if="item.type.indexOf('image') < 0 ">
              <i class="fa fa-files-o" aria-hidden="true"></i>
            </div>
            <a :href="item.url" target="_blank">{{item.titulo}}</a>
            <a href="#!" v-on:click="remover(item, index)"  
                       v-if="show_botao_upload">
              <i class="fa fa-trash-o" aria-hidden="true"></i>
            </a>
          </div>
        </div>
      </div>


  </div>
  </div>

  </div>
</template>

<script>
import upload from "./upload.vue";

export default {
  components: { upload },
  props: [
    "id_registro",
    "id_tabela",
    "pShowUpload",
    "unique_id",
    "titulo",
    "onLoadData",
    "tamanho_coluna",
    "box_estilo",
  ],

  data: function() {
    return {
      action: "list",
      items: [],
      id: "",
      index_selecionado: "",
      texto_pesquisa: "",

      loading: false,
      msg_status: "Carregando",
      v_visivel_upload: false,
      img_loading: "loading.gif",
      show_botao_upload: true
    };
  },
  mounted() {
     if (this.pShowUpload != null && this.pShowUpload == false) {
       this.show_botao_upload = false;
     }

    this.loadData();
  },
  methods: {
    getEstilo(estilo){
      if ( this.box_estilo == null || this.box_estilo == undefined || this.box_estilo ){
        return estilo;
      }

      return "";

    },
    loadData() {
      var self = this;
      self.loading = true;

        var data = {id_registro: this.id_registro,  id_tabela: this.id_tabela}

        console.log("LoadData?", data );

        obj_api.call("midia?"+ obj_api.serialize(data) , "get", data, function (response){

              self.items = response.data;
              self.loading = false;

              if (self.onLoadData != null) {
                self.onLoadData(response.data);
              }

        }  );
    },

    getID(tip) {
      return this.unique_id + tip;
    },

    show_botao_upload_old() {
      if (this.pShowUpload != null && this.pShowUpload == "false") {
        return false;
      }

      return true;
    },
    show_upload() {
      return this.v_visivel_upload;
    },
    botao_mostra_upload() {
      this.v_visivel_upload = !this.v_visivel_upload;
    },

    style_list() {
      if (this.action == "form" || this.action == "formsel") {
        return "display:none";
      }
      return "";
    },

    onDelete(id) {
      this.loadData();
    },
    onSave(data, tipo) {
      console.log("onSave?", data );
      
      var self = this;
      if (tipo == "upload") {
        self.loadData();
      }
    },
    remover(item, index) {
      var self = this;

       obj_alert.confirm("Atenção", "Deseja realmente excluir este arquivo?", "question", function (result){

        if ( result.value ){

             obj_api.call_delete("midia",  item.id, function(response){
                                            self.items.splice(index, 1);
                                } );

        }
               

       });

   /*
      if (!confirm("Atenção. Deseja realmente excluir este arquivo?")) {
        return false;
      }
  */
    

      //service.delete(item.id).then(function(response) {
      //  self.items.splice(index, 1);
      //});

      /* Swal.fire({
        title: "Atenção!",
        html: "Deseja realmente excluir este arquivo?",
        showCancelButton: true,
        confirmButtonClass: "md-button md-success",
        cancelButtonClass: "md-button md-danger",
        buttonsStyling: false,
        allowOutsideClick: false
      }).then(result => {
        if (result.value) {
          service.delete(item.id).then(function(response) {
            self.items.splice(index, 1);
          });
        }
      }); */
    }
  }
};
</script>