export default { 


    removeColumns(form, cols_remove){

         var newform = this.clone(form);

         var ar = cols_remove.split(',');

         for ( var i = 0; i < ar.length; i++ ){

                     var key = cols_remove[i];

                     delete newform[key];
         }


         return newform;



    },


    clone(obj) {
        if (null == obj || "object" != typeof obj) return obj;
        var copy = obj.constructor();
        for (var attr in obj) {
            if (obj.hasOwnProperty(attr)) copy[attr] = obj[attr];
        }
        return copy;
    },

    serialize (obj ){

                var str = [];
                for (var p in obj)
                if (obj.hasOwnProperty(p)) {
                    str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
                }
                return str.join("&");


   }
 




}