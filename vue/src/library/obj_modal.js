var obj_modal = {
    
    open: function (url, width, height){
        
        
              window.jQuery.colorbox({iframe: true, 
                        href: window.URL_BASE +url, innerWidth: width, innerHeight: height});
        
    }
    
    
}

window.obj_modal = obj_modal;
