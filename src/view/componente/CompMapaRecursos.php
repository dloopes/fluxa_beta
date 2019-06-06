<?php
namespace Fluxa\View\Componente;

use Fluxa\View\Componente\IComponente;
use Fluxa\Entity\Recurso;
use Fluxa\Entity\EnumTiposFluxo;
use Fluxa\Entity\EnumRecursoStatus;

class CompMapaRecursos implements IComponente {

	private $listaPotencialidade;
	private $listaPossibilidade;

	//Centralizado no Brasil
	private $latitudeCenter = -16.3292895;
	private $longitudeCenter = -57.1478178;

	private $zoomDefault = 4;

	private $totalMarker = 0;

	private $heightMap = "650px";

	private $markerOpened = false;

    public function __construct($listaPotencialidade, $listaPossibilidade) {
       $this->listaPotencialidade = $listaPotencialidade;
       $this->listaPossibilidade = $listaPossibilidade;

       $this->totalMarker = (count($this->listaPossibilidade) + count($listaPotencialidade));
    }

    public function setLatitudeCenter($latitudeCenter){
    	$this->latitudeCenter = $latitudeCenter;
    }

    public function setLongitudeCenter($longitudeCenter){
    	$this->longitudeCenter = $longitudeCenter;
    }

    public function setZoomDefault($zoomDefault){
    	$this->zoomDefault = $zoomDefault;
    }

    public function setHeightMap($heightMap){
    	$this->heightMap = $heightMap;
    }

    public function setMarkerOpened($markerOpened){
    	$this->markerOpened = $markerOpened;
    }
    
    public function getMarkerOpened(){
    	return $markerOpened;
    }

    public function imprimeHTML($showHeaderMap = true) {
        ?>
        <section class="content">	
			<div class="row">
				<div class="col-md-12">
					<div class="row hidden-xs hidden-sm">
						
						<?php
						if($showHeaderMap){
							?>
							<h4><?php echo($this->totalMarker)?> recurso(s) apresentado(s) no mapa</h4>
							<?php
						}
						?>
						
						<div id="map" style="height: <?php echo($this->heightMap)?>; width: auto; border-style: groove; border-width: 1px;"></div>
					</div>		
				</div>		
			</div>		
		</section>

		<script type="text/javascript">
   
			function initMap() {

				var map = new google.maps.Map(document.getElementById('map'), {
					zoom: <?= $this->zoomDefault ?>,
					center: {lat: <?= $this->latitudeCenter?>, lng: <?= $this->longitudeCenter ?>}
				});

				//Incluindo Recursos ao mapa
				<?php
				if (isset($this->listaPotencialidade) && count($this->listaPotencialidade) > 0) {

					?>
					var image = 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png';
					<?php

					foreach($this->listaPotencialidade as $recurso) {

						$endereco = $recurso->getEndereco();

						if(!empty($endereco)){

							if (!empty($endereco->getLatitude()) && !empty($endereco->getLongitude())) {

								$usuario = $recurso->getUsuario();

								?>
								var marker = new google.maps.Marker({
									position : new google.maps.LatLng(<?php echo($endereco->getLatitude())?>, <?php echo($endereco->getLongitude())?>),
									title : "<?php echo($recurso->getNome())?>",
									map : map,
									icon: image
								});							

								var contentString = '<div id="content" style="padding: 15px 10px 10px 25px;">'+
						            '<div id="siteNotice">'+
						            '<h3 class="text-center text-aqua">OFERTA</h3>'+ 
						            '</div><br/>'+
						            '<p>Usuário: <b><?php echo($usuario->getNome())?></b></p>'+         
						            '<p>Contato: <b><?php echo($usuario->getEmail())?></b></p>'+
						            '<p>Recurso: <b><?php echo($recurso->getNome())?></b></p>'+
						            '<div id="bodyContent">'+
						            '<p>Status: <b><?php echo(EnumRecursoStatus::getValueView($recurso->getStatus()))?></b></p>'+
						            '<p>Tipo de Fluxo: <b><?php echo(EnumTiposFluxo::getValueView($recurso->getTipoFluxo()))?></b></p>'+   
						            '<div class="text-center" style="margin-top: 20px;">'+ 
						            <?php 
						            if($usuario->getId() != $_SESSION['id']){
						            	?>						            	
						            	'<form method="POST" action="/sistema/fluxo" id=<?php echo("form_"+$recurso->getId())?>>'+ 
						            		'<input type="hidden" name="id_recurso" value=<?php echo($recurso->getId())?> />'+ 
						            	 	'<input type="button" style="min-width: 100px;" class="btn btn-success btn-sm" title="Fluxar" onclick="sendFormFluxo(<?php echo("form_"+$recurso->getId())?>);" value="Fluxar"/>'+ 
						            	'</form>'+ 							            
						            	<?php
						            }
						            ?>
						        	'</div>'+
						            '</div>'+
						            '</div>';

						    	attachSecretMessage(marker, contentString);
								<?php
							}

						}
					}
				}

				if (isset($this->listaPossibilidade) && count($this->listaPossibilidade) > 0) {
					?>
					var image = 'http://maps.google.com/mapfiles/ms/icons/green-dot.png';
					<?php

					foreach($this->listaPossibilidade as $recurso) {

						$endereco = $recurso->getEndereco();

						if(!empty($endereco)){

							if (!empty($endereco->getLatitude()) && !empty($endereco->getLongitude())) {

								$usuario = $recurso->getUsuario();

								?>
								var marker = new google.maps.Marker({
									position : new google.maps.LatLng(<?php echo($endereco->getLatitude())?>, <?php echo($endereco->getLongitude())?>),
									title : "<?php echo($recurso->getNome())?>",
									map : map,
									icon: image
								});							

								var contentString = '<div id="content" style="padding: 15px 10px 10px 25px;">'+
						            '<div id="siteNotice">'+
						            '<h3 class="text-center text-green">NECESSIDADE</h3>'+ 
						            '</div><br/>'+
						            '<p>Usuário: <b><?php echo($usuario->getNome())?></b></p>'+         
						            '<p>Contato: <b><?php echo($usuario->getEmail())?></b></p>'+
						            '<p>Recurso: <b><?php echo($recurso->getNome())?></b></p>'+
						            '<div id="bodyContent">'+
						            '<p>Status: <b><?php echo(EnumRecursoStatus::getValueView($recurso->getStatus()))?></b></p>'+
						            '<p>Tipo de Fluxo: <b><?php echo(EnumTiposFluxo::getValueView($recurso->getTipoFluxo()))?></b></p>'+ 
						            '<div class="text-center" style="margin-top: 20px;">'+ 
						            <?php 
						            if($usuario->getId() != $_SESSION['id']){
						            	?>						            	
						            	'<form method="POST" action="/sistema/fluxo" id=<?php echo("form_"+$recurso->getId())?>>'+ 
						            		'<input type="hidden" name="id_recurso" value=<?php echo($recurso->getId())?> />'+ 
						            	 	'<input type="button" style="min-width: 100px;" class="btn btn-success btn-sm" title="Fluxar" onclick="sendFormFluxo(<?php echo("form_"+$recurso->getId())?>);" value="Fluxar"/>'+ 
						            	'</form>'+ 							            
						            	<?php
						            }
						            ?>
						        	'</div>'+
						            '</div>'+
						            '</div>';

						    	attachSecretMessage(marker, contentString);

								<?php
							}

						}
					}
				}
				?>

				// Add a marker clusterer to manage the markers.
				var markerCluster = new MarkerClusterer(map, markers,
				  {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
			}

			function attachSecretMessage(marker, secretMessage) {

				var infowindow = new google.maps.InfoWindow({
				  content: secretMessage
				});

				marker.addListener('click', function() {
				  infowindow.open(marker.get('map'), marker);
				});

				<?php

					if($this->markerOpened){
						?>
						infowindow.open(marker.get('map'), marker);
						<?php
					}

				?>
				
			}

		</script>

		<script async defer src="www.google.com.br/geresuaAPIabaixo">
		</script>
		<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>      
		<?php
    }
}
