//Nunca me lembro das chamadas da biblioteca sweetalert, então vou jogar um facilitador aqui.
var obj_alert = {


        confirm: function(title, msg, tip, fn_final ){

            if (tip == null) {
                tip = "question"; //warning
            }

            swal({
                title: title,
                text: msg,
                type: tip,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim'
            }).then(
                function (result) {

                        if (fn_final != null) {
                            fn_final(result);
                        }
                }

            );
    },

    isvazioInput(id, msg){

        if ( $("#"+id).val() == "" ){
            var fn_final = function(obj){
                 $("#"+id).focus();
            };


            obj_alert.show("Atenção", msg, "warning", fn_final, 4000 );
            return true;
        }

        return false;
    },


    show: function(title, msg, tip, fn_final, timer ) {

        if (tip == null) {
            tip = "info"; //warning
        }

         if ( timer == undefined )
            timer = null;

        swal({
            title: title,
            text: msg,
            type: tip,
            confirmButtonText: 'OK',
            timer: timer
        }).then(
            function (result) {

            if (fn_final != null) {
                fn_final(result);
            }
          }
        );
    }

}

window.obj_alert  = obj_alert;