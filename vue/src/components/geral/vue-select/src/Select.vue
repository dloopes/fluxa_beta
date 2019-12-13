<template>
  <div>
    <div style="position:relative" v-bind:class="{'open':openSuggestion}">
      <div class="input-group">
        <input
          class="form-control"
          type="text"
          v-model="selection"
          @keydown.enter="enter"
          @keydown.down="down"
          @keydown.up="up"
          @keydown.esc="limpar"
          @input="change"
          :placeholder="placeholder"
        />

        <span class="input-group-addon">
          <button v-if="false" type="button" title="Limpar" class="btn btn-default btn-flat"></button>
          <button v-if="false" type="button" class="btn btn-info btn-flat" v-on:click="abrirTudo"></button>
          <i
            v-on:click="limpar"
            v-if="internal_value != null || selection !== ''"
            style="cursor:pointer"
            class="fa fa-close"
          ></i>

          <i v-if="!openAll" class="fa fa-arrow-down" v-on:click="abrirTudo" style="cursor:pointer"></i>
          <i v-if="openAll" class="fa fa-arrow-up" v-on:click="abrirTudo" style="cursor:pointer"></i>
        </span>
      </div>

      <ul class="dropdown-busca" v-if="!openAll" :id="name+'_list'" style="width:100%">
        <li
          v-for="(suggestion, index) in matches"
          v-bind:class="{'active': isActive(index)}"
          @click="suggestionClick(index, suggestion.value, suggestion.label)"
          :key="index"
        >{{ suggestion.label }}</li>
      </ul>

      <ul class="dropdown-busca" v-if="openAll" :id="name+'_list'" style="width:100%">
        <li
          v-for="(suggestion, index) in matches"
          v-bind:class="{'active': isActive(index)}"
          @click="suggestionClick(index, suggestion.value, suggestion.label)"
          :key="index"
        >{{ suggestion.label }}</li>
      </ul>
    </div>

    <select
      v-model="internal_value"
      v-on:change="change_value"
      v-bind:name="name"
      v-bind:id="name"
      v-show="false"
    >
      <option v-for="item in options" :key="item.value" :value="item.value">{{item.label}}</option>
    </select>
  </div>
</template>
<style>
.dropdown-busca {
  position: absolute;
  top: 100%;
  left: 0;
  z-index: 1000;
  display: none;
  float: left;
  min-width: 160px;

  max-height: 200px;
  overflow-y: scroll;

  padding: 5px 0;
  margin: 2px 0 0;
  font-size: 14px;
  text-align: left;
  list-style: none;
  background-color: #fff;
  -webkit-background-clip: padding-box;
  background-clip: padding-box;
  border: 1px solid #ccc;
  border: 1px solid rgba(0, 0, 0, 0.15);
  border-radius: 4px;
  -webkit-box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
}

.open > .dropdown-busca {
  display: block;
}
.dropdown-busca li {
  padding-left: 10px;
  color: #333;
  cursor: pointer;
}

.dropdown-busca .a_item {
  color: #333 !important;
}
.dropdown-busca .a_item:hover {
  color: white !important;
}
.dropdown-busca li:hover {
  background-color: #fb8c00 !important;
  color: white;
}
.dropdown-busca li a:hover {
  color: white;
  font-weight: bold;
}
</style>

<script >
//import $ from "jquery";

export default {
  props: {
    /**
     * Contains the currently selected value. Very similar to a
     * `value` attribute on an <input>. You can listen for changes
     * using 'change' event using v-on
     * @type {Object||String||null}
     */
    value: {},

    name: {
      type: String,
      default() {
        return "id_select";
      }
    },
    onChange: {
      type: Function,
      default() {
        return null;
      }
    },
    placeholder: {
      type: String,
      default() {
        return "Digite para pesquisar";
      }
    },
    /* selection: {
      type: String,
      //required: false,
      //twoWay: true
    }, */

    options: {
      type: Array,
      default() {
        return [];
      }
    }
  },
  watch: {
    value: function(val) {
      this.internal_value = this.value;
      this.verifica_se_tem();
    },
    options: function(val) {
      this.verifica_se_tem();
    }
  },
  data() {
    return {
      internal_value: null,
      open: false,
      openAll: false,
      selection: "",
      current: 0
    };
  },
  model: {
    prop: "value",
    event: "input"
  },

  computed: {
    matches() {
      //if ( this.selection === ""){
      //          return this.options;
      // }
      return this.options.filter(str => {
        return (
          str.label.toLowerCase().indexOf(this.selection.toLowerCase()) >= 0
        );
      });
    },

    openSuggestion() {
      return (
        this.openAll ||
        (this.selection !== "" &&
          this.matches.length != 0 &&
          this.open === true)
      );
    }
  },
  mounted() {
    this.internal_value = this.value;
    //this.setAutocompleteJquery();
    //  $("#" + this.name).select2();
  },
  methods: {
    change_value() {
      this.$emit("input", this.internal_value);
      this.$emit("change", this.internal_value);

      if (this.onChange != null) {
        this.onChange(this.internal_value);
      }
    },
    abrirTudo() {
      let stat = !this.openAll;
      this.limpar();
      this.openAll = stat;
    },

    enter() {
      if (this.current < 0) return;

      if (this.current > this.matches.length) return;

      var localizado = this.matches[this.current];

      this.suggestionClick(this.current, localizado.value, localizado.label);

      this.selection = localizado.label;
      //console.log("enter?", this.current, this.matches[this.current] );
      this.open = false;
      this.openAll = false;
    },

    up() {
      if (this.current > 0) {
        this.current--;
        this.openAll = true;
        this.scrollTo(this.current);
      }
    },

    down() {
      if (this.current < this.matches.length - 1) {
        this.current++;
        this.openAll = true;
        this.scrollTo(this.current);
      } else {
        if (this.matches.length > 0) {
          this.current = this.matches.length - 1;
        }
      }
    },

    isActive(index) {
      return index === this.current || index == this.current;
    },

    change() {
      if (this.open == false) {
        this.open = true;
        this.current = 0;
      }
    },
    verifica_se_tem() {
      if (this.internal_value == null) {
        return;
      }
      for (var i = 0; i < this.options.length; i++) {
        if (this.options[i].value == this.internal_value) {
          this.selection = this.options[i].label;
          this.$emit("update:label_selected", this.selection);
          return;
        }
      }
    },

     scrollTo(elementIndex) {
      var self = this;
      $(document).ready(function() {
        var div_id = self.name + "_list";
        var div = $(document.getElementById(div_id));
        var li = div[0].children[elementIndex];
        var scrollTopDiv = div[0].scrollTop;
        var scrollFinal = scrollTopDiv + div[0].offsetHeight - 25; //Compensar um tamanho aqui..

        // console.log("scroll?", elementIndex, div_id);
        // console.log(div);
        if (li != null) {
          var objli = $(li);
          //console.log(objli);
          //var target_offset = objli.offset();
          //var target_top = target_offset.top;

          var target_top = objli[0].offsetTop;

          // console.log("top? ", target_top, scrollTopDiv, scrollFinal);
          if (target_top < scrollTopDiv) {
            if (target_top > 50) {
              div.scrollTop(target_top - 50);
            } else {
              div.scrollTop(target_top);
            }
          }
          if (target_top >= scrollFinal) {
            div.scrollTop(target_top - 50);
          }

          //   ();
          //$('html, body').animate({
          //        scrollTop: target_top
          //}, 800);
        }
      });
    },

    suggestionClick(index, id, label) {
      this.selection = label;
      this.internal_value = id;
      // this.selection = this.matches[index].label;
      //this.value = this.matches[index].value;
      // this.internal_value = this.matches[index].value;
      this.open = false;
      this.openAll = false;

      this.$emit("input", this.internal_value);
      this.$emit("change", this.internal_value);

      this.$emit("update:label_selected", label);

      if (this.onChange != null) {
        this.onChange(this.internal_value);
      }
    },
    limpar() {
      this.selection = "";
      this.internal_value = null;

      this.open = false;
      this.openAll = false;

      this.$emit("input", this.internal_value);
      this.$emit("change", this.internal_value);
      this.$emit("update:label_selected", "");

      if (this.onChange != null) {
        this.onChange(this.internal_value);
      }
    }
  }
};
</script>