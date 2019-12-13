import Vue from 'vue'
//const config = require('../config')

Vue.filter('image_folder', function (value) {
 
     return "/static/image/" + value;
    //return Vue.config.dev.assetsPublicPath + Vue.config.dev.assetsSubDirectory +"/images/"+  value;
});

Vue.filter('show_number', function (value) {
 
        return parseFloat((value).toFixed(2)).toLocaleString();
});

Vue.filter('show_currency', function (value) {
        var formato = { minimumFractionDigits: 2 , style: 'currency', currency: 'BRL' }
        var ret = parseFloat(value).toLocaleString('pt-BR', formato);

        return  ret;
});

Vue.filter('date_show', function (value) {
  if (!value) return ''
  if (value.indexOf("-") <= 0 ) return value;

  value = value.toString();

  var ar = value.split(' ');
  var pedaco_data = ar[0].split('-');

  var data_saida = pedaco_data[2] + "/"+ pedaco_data[1] +"/" + pedaco_data[0];

   return data_saida;
});