
import Swal from 'sweetalert2';

export default {

        confirm(title, text, type, fn_sim, fn_nao) {

                if (type == null || type == undefined) {
                        type = "question";
                }

                Swal.fire({
                        title: title,
                        text: text,
                        type: type,
                        showCancelButton: true,
                        confirmButtonText: "Sim",
                        cancelButtonText: "Não"
                }).then((result) => {
                        if (result.value) {

                                if (fn_sim != null) {
                                        fn_sim(result, title);
                                }
                                // For more information about handling dismissals please visit
                                // https://sweetalert2.github.io/#handling-dismissals
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                                if (fn_nao != null) {
                                        fn_nao(result, title);
                                }
                        }
                })
        },


        show(title, text, type, fn_final, timer) {
                // on select we show the Sweet Alert modal with an input

                if (type == null || type == undefined) {
                        type = "warning";
                }

                let config = {
                        title: title,
                        text: text,
                        type: type,
                        showCancelButton: false,
                        confirmButtonText: "OK",
                };

                if (timer != null && timer != undefined) {
                        config["timer"] = timer;
                }

                Swal.fire(config).then((result) => {

                        if (fn_final != null) {
                                fn_final(result);
                        }
                });

        }
}
