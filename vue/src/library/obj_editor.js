var obj_editor = {

	   current_obj: null,
     onSelectEvent: null,

       currentdate: function(){
              var date = new Date();

                var data_registro = date.getFullYear()+"-"+ 
                   this.formatnumber(date.getMonth()+1)+"-"+ 
                   this.formatnumber( date.getDate());

                   return data_registro;
       },
       formatnumber: function (num){
            if ( num <= 9)
              return "0"+num;

            return num;
       },

       
       aplicar: function (selector,  height, self , file_input_selector){

          console.log("Vamos tentar colocar o tinymce? ");
          console.log(tinymce);

          if ( selector.indexOf("#") > -1){
               tinymce.remove(selector);
               //tinymce.execCommand('mceRemoveControl', true, selector.replace("#",""));
          }

       	    tinymce.init({
            theme: "modern",
            language: 'pt_BR',

            relative_urls : false,
            remove_script_host : true,
            convert_urls : true,
            extended_valid_elements:'script[language|type|src]',

            height: height,
            selector: selector,
            content_css: [window.CSS_BOOTSTRAP_URL, window.CSS_SITE_URL ],
            // Inserir imagem local
            plugins: ["image"],
            file_browser_callback: function (field_name, url, type, win) {
                if (type == 'image') {
                	
                	 var data = {  field_name: field_name, url: url, type: type , win: win };
                	 console.log("recebido: "); console.log( data );

                	obj_editor.call_upload( data, self );
                	$(file_input_selector).click();

                    //file_summernote
                    // window.obj_upload.uploadImagem( files, "imgpost", self);
                    //document.forms[0].acao2.value = field_name + "|" + url + "|" + type;
                    //alert( field_name );
                    //alert("cheguei aqui ?");
                    //$('#file_imagem').click();
                }
            },
            // Aumentar font do texto padrão
            setup:
                    function (ed) {
                        ed.on('init', function ()
                        {
                            this.getDoc().body.style.fontSize = '16px';
                        });
                    },
            // Configuração
            plugins: [
                "link image media save print preview code"
            ],
                    toolbar1: "insertfile undo redo | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | link image media | styleselect | forecolor backcolor  | print preview | code ",
                   // toolbar2: "forecolor backcolor  | print preview | code ",
                    image_advtab: true,
        });

            //$(".content-wrapper").css('min-height', '1300px');
            $('.content-wrapper').attr('style','min-height:900px;other-styles');
            console.log("Vou tentar mudar o content wrapper? ");
       },

       call_upload(obj, self){

       	     obj_editor.current_obj = obj;

              // window.obj_upload.uploadImagem( files, "imgpost", self);
       },

       setaContent: function (txt){

       	       tinymce.activeEditor.setContent(txt, {format: 'raw'} );
       },
       addContent: function (html){
                   tinymce.activeEditor.execCommand('mceInsertRawHTML', false, html);
       },

       getContent: function(){
       	       return tinymce.activeEditor.getContent();
       },

       openModal: function (url, width, height){

        console.log("Vou chamar o OpenModal? ");

                      window.jQuery.colorbox({iframe: true, 
                        href: url, innerWidth: width, innerHeight: height});
       },

       returnUpload(retorno){

                 for ( var i = 0; i < retorno.length; i++ ){
                             var item = retorno[i];
                             if ( obj_editor.current_obj != null ){
                                   $("#" + obj_editor.current_obj.field_name).val(item.url);
                             }

                             var number_mce = obj_editor.current_obj.field_name.replace("mceu_","").replace("-inp","");

                             var n_mce = parseInt(number_mce); //35 38 40
                                 n_mce += 3;

                                 console.log("estou aqui? " + "#mceu_"+n_mce.toString()+"-inp" );
                                 //var oo = document.getElementById("mceu_"+n_mce.toString()+"-inp");
                                 //console.log(oo);

                             //$("#mceu_"+n_mce.toString()+"-inp").val( item.width );
                             document.getElementById("mceu_"+n_mce.toString()+"").value = item.width.toString();

                                  n_mce += 2;
                             document.getElementById("mceu_"+n_mce.toString()+"").value = item.height.toString();
                             //$("#mceu_"+n_mce.toString()+"-inp").val( item.height );

            }

       },
       
       setcalendar: function (obj, event){
              this.focus_data(obj);
       },


       loadCalendar: function(selector){

		       	 $(selector).datepicker({
		               dateFormat: 'dd/mm/yy',
		               dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
		               dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
		               dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
		               monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
		               monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
		               nextText: 'Proximo',
		               prevText: 'Anterior'
		            });
                            
                            console.log("Tentando aplicar o calendar: ");
                            console.log( $(selector));
       },
       
        focus_data: function (obj){

          if ( obj_editor.onSelectEvent == null || obj_editor.onSelectEvent == undefined ){
                obj_editor.onSelectEvent = function(dateText, inst){
                  console.log("Mudando dateText: " + dateText );
                  console.log( inst );
                } 
          }

    
          if ( ! $("#"+obj.id).hasClass("hasDatepicker") ){
          
                      $("#"+obj.id).datepicker({
        		               dateFormat: 'dd/mm/yy',
        		               dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
        		               dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
        		               dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
        		               monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
        		               monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
        		               nextText: 'Proximo',
        		               prevText: 'Anterior',
                           onSelect: obj_editor.onSelectEvent
                                 //function(dateText, inst) {
                                 //    $('#'+inst.id).attr('value',dateText);
                                 // }
        		            });
                      $("#"+obj.id).focus();
                      $("#"+obj.id).click();
                      console.log("tentando adicionar o datepicker");
           }
       },
       
       mascara: function (e,src,mask) {
                if(window.event) {
                _TXT = e.keyCode;
                } else
                if(e.which) {
                _TXT = e.which;
                }
                if(_TXT > 47 && _TXT < 58) {
                var i = src.value.length;
                var saida = mask.substring(0,1);
                var texto = mask.substring(i);
                if(texto.substring(0,1) != saida) {
                src.value += texto.substring(0,1);
                }
                return true;
                } else {
                if (_TXT != 8) {
                return false;
                } else {
                return true;
                }
                }
        }



}

window.obj_editor = obj_editor;