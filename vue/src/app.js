


require('./obj_upload');
require('./obj_alert');
require('./library/obj_editor.js');
require('./library/obj_datatable.js');
require('./library/obj_mask.js');
require('./library/obj_modal.js');

require('./jquery-1.9.1.min');
require('./jquery.colorbox');
require('./jquery-ui-1.9.2.custom.min');

require('./obj_api.js');
require('./filters.js');


import Vue from 'vue'
import App from './App.vue'


import Upload from './components/images/upload.vue'
import Select from './components/geral/vue-select/src/Select.vue'
import UploadUnico from './components/images/UploadUnico.vue'
import Imagebanner from './components/images/banner.vue'
import UploadFolder from './components/images/uploadFolder.vue'
import RecursosForm from './components/recurso/RecursoForm.vue'
import RecursosList from './components/recurso/RecursoList.vue'
import RecursoAssociacao from './components/recurso/recurso_associacao.vue'
import RecursoTodos from './components/recurso/ListTodos.vue'
//import uc_pesquisacodigonome from './components/pesquisa/uc_pesquisacodigonome.vue'
//import MovimentacaoForm from './components/movimentacao/MovimentacaoForm.vue'


Vue.component('upload', Upload);
Vue.component('upload-unico', UploadUnico);
Vue.component('imagebanner', Imagebanner);
Vue.component('upload-folder', UploadFolder);
Vue.component('recurso_list', RecursosList);
Vue.component('recurso_form', RecursosForm);
Vue.component('recurso_associacao', RecursoAssociacao);
Vue.component('vue_select', Select);
Vue.component('recurso_todos', RecursoTodos);


//Vue.component('uc_pesquisacodigonome', uc_pesquisacodigonome);
//Vue.component('movimentacao_form', MovimentacaoForm);


/*
new Vue({
  el: '#app',
  render: h => h(App)
})
*/


window.Vue = require('vue');

$(document).ready(function() {
 if ( document.getElementById("app") != null ){
            const app = new Vue({
              el: '#app'
          });
 }
	
	/*
        const app = new Vue({
            el: '#app_vue'            
          // , render: h => h(Imagebanner)
            , components: { App }
           // router,
        });

        */

});
