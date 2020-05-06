 <template>
  <div>
    <section class="col-xs-12">
      <div class="box">
        <div class="box-header with-border">Endereço</div>
        <div class="box-body">
          <div class="col-xs-4">
            <label>Tipo de endereço:</label>
            <select
              :value="tipo_endereco"
              class="form-control"
              v-on:change="$emit('update:tipo_endereco', $event.target.value)"
            >
              <option value="F">Físico</option>
              <option value="V">Virtual</option>
            </select>
          </div>

          <div class="col-xs-8" v-if="tipo_endereco=='V'">
            <label>Informe a URL de acesso:</label>
            <input
              class="form-control"
              :value="url_endereco_virtual"
              v-on:change="$emit('update:url_endereco_virtual', $event.target.value)"
              type="text"
              maxlength="900"
              name="f_url_endereco_virtual"
              id="f_url_endereco_virtual"
              placeholder="Informe a URL"

              required
            />
          </div>

          <cad_endereco v-if="tipo_endereco =='F' && monitora" v-model="form" :onSelected="onSelected"></cad_endereco>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import Util from "../../library/Util";
import service from "../../services/EnderecoService";
export default {
  props: ["tipo_endereco", "url_endereco_virtual", "form_endereco"],
  model: {
    prop: "form_endereco",
    event: "selected"
  },
  data: function() {
    return {
      form: {},
      monitora: false
    };
  },
  methods:{
    onSelected(form){
          this.$emit("selected", form);

    }
  },

  mounted() {
    let self = this;

    this.form = { ...this.form_endereco };
    //Depois desse passo eu começo a monitorar o form...
    this.monitora = true;
  },

  watch: {
    form: {
      // This will let Vue know to look inside the array
      deep: true,

      // We have to move our method to a handler field
      handler() {
        if (this.monitora) {
          this.$emit("selected", this.form);
        }
      }
    }
  }
};
</script>