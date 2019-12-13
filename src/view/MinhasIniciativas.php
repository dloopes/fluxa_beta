<!-- Main content -->
<section class="content-header" style="margin-left: 15px">
  
  <h1>
    Minhas Iniciativas 
  </h1>

  <ol class="breadcrumb">
    <li><a href="/sistema/painel"><i class="fa fa-th"></i> Painel</a></li>
  </ol>

</section>

<section class="content">
	
    
    	<div class="row" id="app">
		<div class="col-xs-12">
                            <?php if ( @$_GET["acao"] == "cad") { ?>
                                      <recurso_form post_type="iniciativa" ></recurso_form>
                    
                             <?php } else { ?>
                                      <recurso_list post_type="iniciativa" ></recurso_list>
                             <?php } ?>
                        
                            
                        
                    </div>
        </div>
</section>