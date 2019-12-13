import axios from 'axios';
import Api from '../library/Api.js';
import base from './ServicoBase.js';

export default {

      getModel(){   


      	    var form = {
                      id: null , 
                              arquivo: "", 
                              type: "", 
                              id_tabela: "", 
                              titulo: "", 
                              tamanho: "", 
                              id_registro: null , 
                              old_nome: "", 
      	    }

      	    return form;
      },

      getById(id){

                  return Api.Call("arquivo/" + id + "", "get", {});

      },

      salvar(form, fn_progress){
            
            
            if ( form.id != null && form.id != ""){
                 // var data = base.removeColumns( form, "cadastrado_por,valido,verificado,eliminado");
                  return Api.Call("arquivo/" + form.id + "", "PUT", form, fn_progress );
            } else {

                  
                return Api.Call("arquivo" , "POST", form, fn_progress);


            }      

      },
      delete(id){
            return Api.Call("arquivo/" + id + "", "DELETE", {} );
      },
      filtrar(page, search ){

      	var data = {filtro: search , page: page, pagesize: process.env.VUE_APP_PAGESIZE}

      	return Api.Call( "arquivo_grid" , "get", data );


     },
     
     getList(id_registro, id_tabela){

        var data = {id_registro: id_registro,  id_tabela: id_tabela}

        return Api.Call( "arquivos?" + base.serialize(data) , "get", data );


     },
	 
	  getListByParent( tabela, id_pai  ){

      
        var data = {tabela: tabela,  id_pai: id_pai }

      	return Api.Call( "arquivo_gridcad?" + base.serialize(data) , "get", data );


     },
	 
	 salvarGrid( hd_json, ids_delete_json, tabela, id_pai ){

        var data = {
            hd_json: hd_json,
            ids_delete_json: ids_delete_json,
            tabela: tabela,
            id_pai: id_pai
        };

        return Api.CallFormData("arquivo_salvargrid" , "POST", data);
        
     }


}
