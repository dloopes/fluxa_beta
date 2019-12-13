<?php

# Arquivo: thumb.php
# Autor: Helbert Fernandes - estaleiroweb
# baseado no trabalho de Mauricio Wolff
include "fileinc.php"; // Inclusão de funcões de Caminho e Diretório

// Constantes: variaveis que não mudam em todo o programa
define('MAX_WIDTH' , (isset($_GET['x']))?$_GET['x']:160);
define('MAX_HEIGHT', (isset($_GET['y']))?$_GET['y']:120);

# Pega onde está a imagem
$temp=explode('/',$_GET['img']);
$image_file = array_pop($temp);
$image_path = implode('/',$temp);
$image_path= $image_path.(($image_path=='')?'':'/');

if ( @$_GET['debug'] == "1"){
	echo(" File exist? ".$image_path.$image_file." - ". file_exists($image_path.$image_file) );
}

//die ( $image_path.$image_file. " ->" .realpath( $image_path)."/".$image_file . " --->" . file_exists( realpath( $image_path)."/".$image_file ) );
# Carrega a imagem
if (!file_exists($image_path.$image_file)) $image_file='';




$ar_tmp =explode('.',$image_file);
//die(" .. ". strtolower(end($ar_tmp)) );

switch (strtolower(end($ar_tmp))) {
	case 'jpg':
	    //die("aqui?");

		$img = @imagecreatefromjpeg($image_path.$image_file);
		correctImageOrientation($image_path.$image_file, $img );
		//print_r( $img  ); die(" ");

		mostraImg('imagejpeg',$img,MAX_WIDTH,MAX_HEIGHT);
		break;
	case 'jpeg':
	    //die("aqui?");

		$img = @imagecreatefromjpeg($image_path.$image_file);
		//print_r( $img  ); die(" ");

		mostraImg('imagejpeg',$img,MAX_WIDTH,MAX_HEIGHT);
		break;
	case 'png':
		$img = @imagecreatefrompng($image_path.$image_file);
		mostraImg('imagepng',$img,MAX_WIDTH,MAX_HEIGHT);
		break;
	case 'gif':
		$img = @imagecreatefromgif($image_path.$image_file);
		mostraImg('imagegif',$img,MAX_WIDTH,MAX_HEIGHT);
		break;
	case 'bmp':
		$img = @imagecreatefromwbmp ($image_path.$image_file);
		mostraImg('imagewbmp',$img,MAX_WIDTH,MAX_HEIGHT);
		break;
	default:
	    $img = imagecreate(160, 120);
	    imagecolorallocate($img, 204, 204, 204);
	    $c = imagecolorallocate($img, 153, 153, 153);
	    $c1 = imagecolorallocate($img, 0, 0, 0);
	    imageline($img, 0, 0, 160, 120, $c);
	    imageline($img, 160, 0, 0, 120, $c);
	    imagestring($img, 5, 60, 20, "ERRO:", $c1);
	    imagestring($img, 5, 65, 50, "Sem", $c1);
		imagestring($img, 5, 50, 70, "Imagem".$image_path. $image_file, $c1);
		mostraImg('imagejpeg',$img,MAX_WIDTH,MAX_HEIGHT);
}

function tamanhoImg($img,$x,$y){
	// Pega o tamanho da imagem e proporção de resize
	$width = imagesx($img);
	$height = imagesy($img);
	$scale = min($x/$width, $y/$height);
	// Se a imagem é maior que o permitido, encolhe ela!
	//die("dados? ". $width . " - ". $height . " -- ". function_exists("imagejpeg")." -- ". $scale);

	if ($scale < 1) {
	    $new_width = floor($scale * $width);
	    $new_height = floor($scale * $height);
		// Cria uma imagem temporária
		//die("new tamanhos ". $new_width . " - ". $new_height);

	    $tmp_img = imagecreatetruecolor($new_width, $new_height);
	    // Copia e resize a imagem velha na nova
	    imagecopyresized($tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
	    imagedestroy($img);
	    $img = $tmp_img;
	}
	//print_r( $img  ); die(" ");
	return $img;
}
function mostraImg($funcao,$img,$x,$y){
	if (!function_exists($funcao)) $funcao='imagejpeg';
	
	switch ($funcao) {

		case 'imagejpeg':
		if ( @$_GET['debug'] == ""){
			header('Content-Type: image/jpeg');
		}
			imagejpeg(tamanhoImg($img,$x,$y));
			break;
		case 'imagegif':
			header('Content-Type: image/gif');
			imagegif(tamanhoImg($img,$x,$y));
			break;
		case 'imagepng':
			header('Content-Type: image/png');
			imagepng(tamanhoImg($img,$x,$y));
			break;
		case 'imagewbmp':
			header('Content-Type: image/vnd.wap.wbmp');
			imagewbmp(tamanhoImg($img,$x,$y));
			break;
	}
	exit();
}
?>
