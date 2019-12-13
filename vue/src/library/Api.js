import axios from 'axios';
import ApiJquery from './ApiJquery';
import FormData from 'form-data';

export default {


        token_user: null,
        vue_component: null,

        getTokenUser: function () {
                if (obj_user.token_user == null) {
                        var res = JSON.parse(window.sessionStorage.getItem("socv2_user"));
                        obj_user.token_api = res.token;

                }

                return obj_user.token_api;

        },

        getFormData(object) {

                const formData = new FormData();
                Object.keys(object).forEach(key => formData.append(key, object[key]));
                return formData;

        }
        ,
        CallPublic(tipo, method, data) {
                var urlBase = process.env.VUE_APP_URL_API; //window.URL_API; 

                let promise1 = new Promise((resolve, reject) => {
                        let url = urlBase + tipo;

                        axios({
                                method: method,
                                url: url,
                                data: data
                        }).
                                then((response) => {

                                        resolve(response);

                                })
                                .catch((error) => {

                                        reject(error);
                                })

                });

                return promise1
        },

        ResfreshToken(user, token_refresh, originalRequest) {

                return new Promise((resolve, reject) => {

                        Api.Call("token/refresh/", "POST", { refresh: token_refresh }).then((response) => {

                                if (response.status == 200) {

                                        //Token renovado.
                                        //Armazenamos o novo Token novo.
                                        originalRequest.headers['Authorization'] = `Bearer ${response.data.access}`;

                                        user.access_token = response.data.access;
                                        UserAuth.storeUser(user);
                                }

                                resolve(response);

                        }).catch(error => {
                                reject(error); //Vou retornar o erro 401 mesmo..
                        })

                });
        },

        Call(tipo, method, data) {

                let self = this;

                return new Promise((resolve, reject) => {


                        let urlBase = process.env.VUE_APP_URL_API; //window.URL_API; 

                        if (urlBase == null) {
                                urlBase = window.URL_API;
                        }

                        if (tipo.endsWith("/")) {
                                //Nenhum método permite essa barra no final, vou tirar isso de todos.
                                tipo = tipo.substr(0, tipo.length - 1);
                                console.log("Barra do final sendo retirada desta url.");
                        }

                        console.log("URL: " + tipo + " -- " + urlBase + " -- " + process.env.VUE_APP_URL_API);

                        let url = urlBase + tipo;
                        let token = self.getTokenUser();

                        axios({
                                method: method,
                                url: url,
                                data: data,
                                headers: {
                                        Accept: 'application/json',
                                        Authorization: 'Bearer ' + token,
                                        "Content-Type": "application/json"
                                }
                        })
                                .then((response) => {
                                        console.log("API Response " + tipo + " method - " + method);

                                        resolve(response);
                                })
                                .catch((error) => {

                                        if (error.response) {

                                                if (error.response.status == 401) {
                                                        console.log("Erro 401!");

                                                }
                                                console.log(JSON.parse(JSON.stringify(error)));

                                                //Deu ruim. Vou tentar chamar com o Jquery a mesma coisa.


                                                reject(error);

                                        } else if (error.request) {

                                                console.log(JSON.parse(JSON.stringify(error)));
                                                reject(error);
                                        } else {

                                                console.log(JSON.parse(JSON.stringify(error)));
                                                reject(error);
                                        }

                                        console.log("Tentando via Jquery " + url);
                                        ApiJquery.call(error.config, function (response) {
                                                console.log("Deu erro no axios, porém deu certo com Jquery.");
                                                console.log(response);
                                        });

                                        //console.log(error.config);
                                });



                });

        },



        ConvertToFormData(p_data) {


                return new Promise((resolve) => {
                        var formData = new FormData()

                        var keys = Object.keys(p_data);

                        for (var i = 0; i < keys.length; i++) {
                                var key = keys[i];

                                if (p_data[key] != null && p_data[key] != undefined) {
                                        formData.append(key, p_data[key]);
                                }

                                if (i >= keys.length - 1) {
                                        resolve(formData);
                                }
                        }
                });


        },

        CallFormData(tipo, method, data, fn_upload_progress) {
                //FormData


                let self = this;

                return self.ConvertToFormData(data).then((formData) => {

                        console.log("CallFormData");
                        console.log(data);
                        console.log(JSON.stringify(formData));
                        console.log(formData.length);
                        //console.log( Object.keys(data) );

                        if (formData.length <= 0) {
                                // alert("Form Data vazio!!");
                                return Promise.reject({ error: "Form data vazio!" });
                        }
                        //transformResponse: undefined
                        return new Promise((resolve, reject) => {


                                let urlBase = process.env.VUE_APP_URL_API; //window.URL_API; 

                                let url = urlBase + tipo;
                                let token = self.getTokenUser();

                                axios({
                                        method: method,
                                        url: url,
                                        data: formData,
                                        processData: false,
                                        headers: {
                                                Authorization: 'Bearer ' + token,
                                                "Content-Type": 'multipart/form-data'
                                        },
                                        onUploadProgress: function (progressEvent) {
                                                var percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                                                if (fn_upload_progress != null && fn_upload_progress != undefined) {
                                                        fn_upload_progress(percentCompleted);
                                                }
                                        }
                                })
                                        .then((response) => {
                                                //console.log("API Response THEN " + tipo);

                                                resolve(response);
                                        })
                                        .catch((error) => {

                                                if (error.response) {

                                                        if (error.response.status == 401) {
                                                                console.log("Erro 401!");

                                                        }
                                                        console.log(JSON.parse(JSON.stringify(error)));

                                                        reject(error);

                                                } else if (error.request) {

                                                        console.log(JSON.parse(JSON.stringify(error)));
                                                        reject(error);
                                                } else {

                                                        console.log(JSON.parse(JSON.stringify(error)));
                                                        reject(error);
                                                }


                                                console.log("Tentando via Jquery " + url);
                                                ApiJquery.callUpload(error.config, function (response) {
                                                        console.log("Deu erro no axios, porém deu certo com Jquery.");
                                                        console.log(response);
                                                });

                                                //console.log(error.config);
                                        });



                        });




                });



        },

        CallFormData2(tipo, method, formData, fn_upload_progress) {
                //FormData


                let self = this;

                return new Promise((resolve, reject) => {


                        let urlBase = process.env.VUE_APP_URL_API; //window.URL_API; 

                        let url = urlBase + tipo;
                        let token = self.getTokenUser();

                        axios({
                                method: method,
                                url: url,
                                data: formData,
                                contentType: "multipart/form-data",
                                //processData: false,
                                headers: {
                                        Authorization: 'Bearer ' + token,
                                        "Content-Type": 'multipart/form-data'
                                },
                                onUploadProgress: function (progressEvent) {
                                        var percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                                        if (fn_upload_progress != null && fn_upload_progress != undefined) {
                                                fn_upload_progress(percentCompleted);
                                        }
                                }
                        })
                                .then((response) => {
                                        //console.log("API Response THEN " + tipo);

                                        resolve(response);
                                })
                                .catch((error) => {

                                        if (error.response) {

                                                if (error.response.status == 401) {
                                                        console.log("Erro 401!");

                                                }
                                                console.log(JSON.parse(JSON.stringify(error)));

                                                reject(error);

                                        } else if (error.request) {

                                                console.log(JSON.parse(JSON.stringify(error)));
                                                reject(error);
                                        } else {

                                                console.log(JSON.parse(JSON.stringify(error)));
                                                reject(error);
                                        }


                                        console.log("Tentando via Jquery " + url);
                                        ApiJquery.callUpload(error.config, function (response) {
                                                console.log("Deu erro no axios, porém deu certo com Jquery.");
                                                console.log(response);
                                        }, formData);

                                        //console.log(error.config);
                                });



                });




        }

}
