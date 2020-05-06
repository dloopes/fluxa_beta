<template>
  <div v-if="monitora">
    <div >
      <div class="col-xs-12">
        <div class="form-group" v-if="items != null && items.length > 0 ">
          <input type="radio" v-model="selectTipoCadastro" value="A" />
          <label>Selecione um endereço cadastrado anterioremente</label>

          <select
            v-model="form.id"
            class="form-control"
            v-on:change="seleciona"
            :disabled="selectTipoCadastro!='A'"
          >
            <option v-for="(item,index) in items" :value="item.id" :key="index">{{item.descricao}}</option>
          </select>
        </div>

        <div class="form-group" v-if="items != null && items.length > 0 ">
          <input type="radio" v-model="selectTipoCadastro" value="N" />
          <label>Cadastrar novo endereço</label>
        </div>
      </div>

      <div v-if="selectTipoCadastro == 'N'">
        <div class="col-xs-12">
          <div class="form-group">
            <label>Este endereço é no Brasil?</label>
            <select v-model="form.tipo_pais" class="form-control" required>
              <option value="Brasil">Sim</option>
              <option value="Outro">Não - O endereço esta em outro país</option>
            </select>
          </div>
        </div>

        <div v-if="form.tipo_pais=='Outro'">
          <div class="col-xs-4">
            <div class="form-group">
              <label>País</label>

              <input
                class="form-control"
                v-model="form.pais"
                type="text"
                placeholder="Digite o nome do país"
                required
              />
            </div>
          </div>
          <div class="col-xs-6">
            <div class="form-group">
              <label>Informe o endereço</label>

              <input
                class="form-control"
                v-model="form.logradouro"
                type="text"
                maxlength="255"
                placeholder="endereço"
                required
              />
            </div>
          </div>
          <div class="col-xs-2">
            <div class="form-group">
              <label>Nº</label>

              <input
                class="form-control"
                v-model="form.numero"
                type="text"
                maxlength="20"
                placeholder="Nº"
                required
              />
            </div>
          </div>
        </div>

        <div v-if="form.tipo_pais == null || form.tipo_pais == 'Brasil' ">
          <div class="col-xs-6">
            <div class="form-group">
              <label>Estado</label>
              <select
                name="form.id_estado"
                class="form-control"
                v-model="form.id_estado"
                v-on:change="onLoadEstado"
              >
                <option
                  v-for="(item,index) in items_estado"
                  :value="item.id"
                  :key="index"
                >{{item.uf}} - {{item.nome}}</option>
              </select>
            </div>
          </div>

          <div class="col-xs-6" v-if="form.tipo_pais=='Brasil'">
            <div class="form-group">
              <label>Município</label>

              <vue_select
                class="vue-select2"
                name="sel_id_cidade"
                v-if="mostra_select"
                :options="items_cidade"
                v-model="form.id_cidade"
                :searchable="true"
                language="pt-BR"
                :onChange="onLoadCidade"
                :placeholder="placeholder_cidade"
              ></vue_select>
            </div>
          </div>

          <div class="col-xs-4">
            <div class="form-group">
              <label>Logradouro</label>

              <input
                class="form-control"
                v-model="form.logradouro"
                type="text"
                placeholder="Logradouro"
                maxlength="250"
                required
              />
            </div>
          </div>

          <div class="col-xs-2">
            <div class="form-group">
              <label>Número</label>

              <input
                class="form-control"
                v-model="form.numero"
                type="text"
                placeholder="Nº"
                maxlength="30"
                required
              />
            </div>
          </div>

          <div class="col-xs-4">
            <div class="form-group">
              <label>Bairro</label>

              <input
                class="form-control"
                v-model="form.bairro"
                type="text"
                placeholder="Bairro"
                maxlength="50"
                required
              />
            </div>
          </div>
          <div class="col-xs-2">
            <div class="form-group">
              <label>CEP</label>

              <input
                class="form-control"
                v-model="form.cep"
                type="text"
                placeholder="CEP"
                maxlength="8"
                required
              />
            </div>
          </div>
        </div>
      </div>
    </div>

    <section class="col-xs-12" v-if="false">
      <!--

import EnderecoForm from './components/endereco/EnderecoForm'
import EnderecoList from './components/endereco/EnderecoList'


Vue.component('endereco_form', EnderecoForm);
Vue.component('endereco_list', EnderecoList );


      -->

      <div class="form-group">
        <div class="btn-group pull-right">
          <button
            type="submit"
            class="btn btn-info"
            v-bind:disabled="disableButton"
            v-on:click="salvar()"
          >{{publicar_titulo}}</button>

          <button
            type="submit"
            class="btn btn-danger"
            v-bind:disabled="disableButton"
            v-if="form.id!='' && parseInt(form.id) > 0"
            v-on:click="excluir()"
          >Excluir</button>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import Util from "../../library/Util";
import service from "../../services/EnderecoService";
export default {
  props: [
    "id_load",
    "post_type",
    "show_back_button",
    "onBack",
    "onSave",
    "tipo",
    "id_recurso",
    "form_endereco",
    "tipo_endereco",

    "onSelected"
  ],
  data: function() {
    return {
      // form: service.getModel(),

      placeholder_cidade: "Carregando cidade",
      mostra_select: false,
      items_cidade: [],
      items_estado: [],
      items: [],
      form_id: null,

      tipo_pais: "Brasil",
      selectTipoCadastro: "N",

      disableButton: false,
      publicar_titulo: "Salvar",
      titulo_acao: "endereco",
      botao_voltar_visible: false,

      show_message: "off",
      message_text: "",
      message_type: "success",
      interval_message: null,
      form: {},
      monitora: false,
      mostra: false,
    };
  },
  model: {
    prop: "form_endereco",
    event: "selected"
  },
  watch: {
    form: {
      // This will let Vue know to look inside the array
      deep: true,

      // We have to move our method to a handler field
      handler() {
        console.log("alguem mudou algo no endereco? ");

        if (this.monitora) {
          this.$emit("selected", this.form);
        }
      }
    },
    form_id: function(val) {
      if (val != undefined) {
        var fteste = this.getFormById(val);
        if (fteste != null) {
          this.form = fteste;
        }
      }
    }
  },

  mounted() {
    let self = this;

    this.form = { ...this.form_endereco };
    //Depois desse passo eu começo a monitorar o form...
    this.monitora = true;

    this.loadInitData();

    this.form_id = this.form_endereco.id;
    console.log("passei pelo moutend ", this.form_endereco );

    this.mostra = true;

    if (this.show_back_button != null && this.show_back_button != undefined) {
      this.botao_voltar_visible = this.show_back_button;
    }

    if (this.id_load == null || this.id_load == "") {
      return;
    }

    /* var url = "endereco/" + this.id_load;

    var method = "get";

    this.disableButton = true;

    var data = {};

    var fn_return = function(retorno) {
      var item = retorno.item;
      self.carregaForm(item);

      self.disableButton = false;
    };

    obj_api.call(url, method, data, fn_return); */
  },
  watch: {
    selectTipoCadastro: function(val) {
      if (val == "N") {
        this.form = service.getModel();
      }
      if (val == "A") {
        if (this.items.length > 0 && this.form.id == null) {
          this.form = this.items[0];
          //      this.$emit("selected", this.form );
        }
      }
      if (val == "V") {
        this.form = service.getModel();

        //   this.$emit("selected", this.form );
      }
      this.$emit("selected", this.form);
    }
  },
  methods: {
    seleciona(event) {
      if (event.target.value != null) {
        for (var i = 0; i < this.items.length; i++) {
          if (this.items[i].id.toString() == event.target.value.toString()) {
            this.form = this.items[i] ;
            this.$emit("selected", this.items[i]);

            if ( this.onSelected != null ){
              this.onSelected( this.items[i] );
            }
            
           //  console.log("emitiu ? ", this.items[i]  );
            return false;
          }
        }
      }
    },
    getFormById(id) {
      if (id == null) return null;

      if (id != null) {
        for (var i = 0; i < this.items.length; i++) {
          if (this.items[i].id.toString() == id.toString()) {
            return this.items[i];
          }
        }
      }
    },
    onLoadEstado() {
      var self = this;

      self.mostra_select = false;

      setTimeout(function() {
        self.loadCidade();
      }, 40);
    },
    onLoadCidade() {},
    loadInitData() {
      var self = this;

      obj_api.call2("estados", "get", {}, function(response) {
        self.items_estado = response.data;

        if (self.form.id_estado == null) {
          self.form.id_estado = self.items_estado[0].id;
        }
        setTimeout(function() {
          self.loadCidade();
        }, 40);
      });

      obj_api.call2("enderecos", "get", {}, function(response) {
        self.items = response.data;

        if (self.items.length > 0) {
          console.log("aquiii  ? ", response.data);
          self.selectTipoCadastro = "A";
        }
      });
    },
    loadCidade() {
      var self = this;

      self.mostra_select = true;

      self.placeholder_cidade = "Carregando cidade..";

      obj_api.call2(
        "cidades",
        "get",
        { id_estado: self.form.id_estado },
        function(response) {
          self.placeholder_cidade = "-Selecione-";
          self.items_cidade = Util.getListToSelect(
            response.data,
            "id",
            "nome",
            null
          );
          console.log("vou mostrar o form:? ", self.form);
          self.mostra_select = true;
        }
      );
    },

    carregaForm(item) {
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

    exibe_error(tipo) {},

    getClassFirstSection() {
      if (this.id != "") return "col-xs-9";

      return "col-xs-12";
    },

    validar() {
      if (obj_alert.isvazioInput("f_id", "Informe o id!")) return false;
      if (obj_alert.isvazioInput("f_cep", "Informe o cep!")) return false;
      if (obj_alert.isvazioInput("f_logradouro", "Informe o logradouro!"))
        return false;
      if (obj_alert.isvazioInput("f_numero", "Informe o numero!")) return false;
      if (obj_alert.isvazioInput("f_complemento", "Informe o complemento!"))
        return false;
      if (obj_alert.isvazioInput("f_bairro", "Informe o bairro!")) return false;
      if (obj_alert.isvazioInput("f_cidade", "Informe o cidade!")) return false;
      if (obj_alert.isvazioInput("f_estado", "Informe o estado!")) return false;

      return true;
    },

    botao_voltar() {
      var self = this;

      if (this.onBack != null && this.onBack != undefined) {
        console.log("clique no voltar!");
        this.onBack(self);
      }
    },

    salvar(tipo) {
      if (!this.validar()) return false;

      let self = this;
      var url = "endereco";
      console.log("url: " + window.URL_API + url);
      var method = "POST";

      if (this.id != null && this.id != "") {
        method = "PUT";
        url = url + "/" + this.id;
      }

      var data = {
        id: this.id,
        cep: this.cep,
        logradouro: this.logradouro,
        numero: this.numero,
        complemento: this.complemento,
        bairro: this.bairro,
        cidade: this.cidade,
        estado: this.estado,
        pais: this.pais,

        latitude: obj_mask.getNumBr($("#f_latitude").val()),

        longitude: obj_mask.getNumBr($("#f_longitude").val()),

        id_usuario: this.id_usuario,
        id_recurso: this.id_recurso,
        id_cidade: this.id_cidade,
        id_estado: this.id_estado
      };

      var fn_return = function(retorno) {
        var item = retorno.item;

        self.carregaForm(item);

        self.show_message = "on";
        self.message_text = "endereco salvo com sucesso!";

        self.interval_message = setInterval(self.clear_message, 6000);

        if (self.onSave != null && self.onSave != undefined) {
          self.onSave(retorno, "save");
        }
      };

      obj_api.call(url, method, data, fn_return);
    },

    clear_message() {
      this.show_message = "off";
      clearInterval(this.interval_message);
    },

    excluir() {
      let self = this;
      var fn_return = function(retorno, tipo) {
        self.onSave(retorno, tipo);
        self.botao_voltar();
      };
      obj_api.call_delete("endereco", this.id, fn_return);
    }
  }
};
</script>
