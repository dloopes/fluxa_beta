<template>
  <cad_endereco_superior
    :tipo_endereco.sync="form.tipo_endereco"
    :url_endereco_virtual.sync="form.url_endereco_virtual"
    v-model="form_endereco"
    v-if="show_endereco"
  ></cad_endereco_superior>
</template>
<script>
import Util from "../../library/Util";
import service from "../../services/EnderecoService";

export default {
  props: {
    id_load: String,
    default: function() {
      return "";
    }
  },
  data: function() {
    return {
      form: {
        id: null,
        nome: "",
        detalhe: "",
        tipo_recurso: "",
        tipo_endereco: "F",
        id_categoria: "",
        status: "",
        tipo_fluxo: "",
        tipo_produto_virtual: null,
        dados: {
          id: "",
          objetivo: "",
          objetivo_ods: "",
          dimensao: "",
          recursos: "",
          categoria: ""
        }
      },
      form_endereco: service.getModel(),
      show_endereco: false,
      disableButton: true
    };
  },

  watch: {
    form: {
      // This will let Vue know to look inside the array
      deep: true,

      // We have to move our method to a handler field
      handler() {
        document.getElementById("hd_form_data").value = JSON.stringify(
          this.form
        );
      }
    },
    form_endereco: {
      // This will let Vue know to look inside the array
      deep: true,

      // We have to move our method to a handler field
      handler() {
        document.getElementById("hd_endereco_data").value = JSON.stringify(
          this.form_endereco
        );

        
        document.getElementById("hd_form_data").value = JSON.stringify(
          this.form
        );
      }
    }
  },
  mounted() {
    var self = this;
    var url = "recursos/" + this.id_load;

    var method = "get";

    this.disableButton = true;
    self.show_endereco = false;

    if (this.id_load == null || this.id_load == ""){
    self.show_endereco = true;
return;
    } 

    var data = {};

    var fn_return = function(retorno) {
      self.form = retorno.item;

      if (self.form.dados == null || self.form.dados == undefined) {
        self.form.dados = {
          id: "",
          objetivo: "",
          objetivo_ods: "",
          dimensao: "",
          recursos: "",
          tipo_endereco: "F"
        };
      }

      if (self.form.id_endereco != null) {
        self.show_endereco = false;
        obj_api.call2(
          "enderecos/" + self.form.id_endereco,
          "get",
          null,
          function(result) {
            if (result.data != null) {
              //console.log("formendereço? ", result.data );
              self.form_endereco = result.data;
            }
            self.show_endereco = true;
          }
        );
      } else {
        
            self.show_endereco = true;
      }
      self.disableButton = false;
    };

    obj_api.call(url, method, data, fn_return);
  }
};
</script>