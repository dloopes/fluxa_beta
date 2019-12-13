import $ from 'jquery';

export default {


        callJquery: function (url, method, data, fn_return) {

                $.ajax({
                        type: method,
                        url: url,
                        contentType: "application/x-www-form-urlencoded",
                        processData: true,
                        data: data,
                        success: function (retorno) {

                                console.log(retorno);

                                if (fn_return != null) {
                                        fn_return(retorno)
                                }


                        },
                        error: function (xhr, status, p3, p4) {
                                var err = "Error " + " " + status + " " + p3 + " " + p4;
                                if (xhr.responseText && xhr.responseText[0] == "{")
                                        err = JSON.parse(xhr.responseText).Message;


                                console.error(err);

                        }
                }).fail(function (response) {
                        var div_error_api = document.getElementById("div_error_api");

                        if (div_error_api != null) {
                                $("#div_error_api").html(response.responseText);

                        }

                });


        },


        //Se der pau com axios, vou chamar com Jquery porque quero ver o responseText do problema.
        call: function (config, fn_return) {

                console.log("Tentando Jquery para uurl => " + config.url + " - " + config.method);
                $.ajax({
                        type: config.method,
                        url: config.url,
                        contentType: config.headers["Content-Type"],
                        processData: config.headers["Content-Type"] != 'multipart/form-data',
                        data: config.data,
                        beforeSend: function (request) {

                                for (var key in config.headers) {
                                        request.setRequestHeader(key, config.headers[key]);

                                }
                        },
                        success: function (retorno) {

                                console.log("Sucesso com Jquery!!");
                                console.log(retorno);

                                if (fn_return != null) {
                                        fn_return(retorno, config.url)
                                }


                        },
                        error: function (xhr, status, p3, p4) {
                                var err = "Error " + " " + status + " " + p3 + " " + p4;
                                if (xhr.responseText && xhr.responseText[0] == "{")
                                        err = JSON.parse(xhr.responseText).Message;


                                console.error(err);

                        }
                }).fail(function (response) {
                        console.log("Falha ao tentar obter dados");
                        console.log(response);

                        if (document.getElementById("div_error_api") != null) {

                                $("#div_error_api").html(response.responseText);

                        }

                });


        },


        //Se der pau com axios, vou chamar com Jquery porque quero ver o responseText do problema.
        callUpload: function (config, fn_return, o_data) {

                if (o_data == null || o_data == undefined) {
                        o_data = config.data;
                }

                console.log("Tentando Jquery para uurl => " + config.url + " - " + config.method);
                $.ajax({
                        type: config.method,
                        url: config.url,
                        contentType: "multipart/form-data",
                        processData: false,
                        data: o_data,
                        beforeSend: function (request) {

                                for (var key in config.headers) {
                                        request.setRequestHeader(key, config.headers[key]);

                                }
                        },
                        success: function (retorno) {

                                console.log("Sucesso com Jquery!!");
                                console.log(retorno);

                                if (fn_return != null) {
                                        fn_return(retorno, tipo)
                                }


                        },
                        error: function (xhr, status, p3, p4) {
                                var err = "Error " + " " + status + " " + p3 + " " + p4;
                                if (xhr.responseText && xhr.responseText[0] == "{")
                                        err = JSON.parse(xhr.responseText).Message;


                                console.error(err);

                        }
                }).fail(function (response) {
                        console.log("Falha ao tentar obter dados");
                        console.log(response);

                        if (document.getElementById("div_error_api") != null) {

                                $("#div_error_api").html(response.responseText);

                        }

                });


        }



}