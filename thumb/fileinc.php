<?php

function arquivoAtivo () {// Retorna o nome do arquivo ativo (que está rodando a aplicação)
	$root=todoCaminho ();
	return substr($root,strrpos($root,'/')+1);
}
function caminhoAtivo () {// Retorna o caminho físico (no servidor) do arquivo ativo
	$root=todoCaminho ();
	return substr($root,0,strrpos($root,'/')+1);
}
function todoCaminho () {
	return str_replace('//','/',str_replace('\\','/',((isset($_SERVER['SCRIPT_FILENAME']))?$_SERVER['SCRIPT_FILENAME']:$_SERVER['PATH_TRANSLATED'])));
}
function URLAtiva () {// Retorna o caminho lógico (URL)do arquivo ativo
	$var=$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
   return substr($var.'/',0,strrpos($var,'/')+1);;
}
function carregaArquivo ($Arquivo) {//Carrega um arquivo na memória
	$fp = fopen ($Arquivo, "r");
   $conteudo = fread ($fp, filesize ($Arquivo));
	fclose($fp);
   return $conteudo;
}
function gravaArquivo ($Arquivo,$conteudo) {
	$fp = fopen ($Arquivo, "w");
   fwrite ($fp, $conteudo); //se der pau use fwrite ($fp, $conteudo,strlen($conteudo));
	fclose($fp);
}
//Funções de manipulação de diretório, caminhos e arquivos.
class Diretorio { //Captura um diretório do HD
	var $Pastas; //Contém as subpastas da pasta especificada respeitando a caixa como foi criada
	var $PastasCaixaBaixa; //O mesmo de $Pastas em minusculas
	var $Arquivos; //Contém os nomes de arquivo da pasta especificada respeitando a caixa como foi criados
	var $Extensao; //Contém as extenções dos arquivos da pasta especificada respeitando a caixa como foi criados
	var $ArquivosCaixaBaixa; //O mesmo de $Arquivos em minusculas
	var $ExtensaoCaixaBaixa; //O mesmo de $Extencao em minusculas
	var $Tamanho; //Tamnho em bytes de cada arquivo
	var $Data; //Data em valor numérico de cada arquivo. Use
	function Lista ($path) { //Especifica qual a pasta a ser capturada o comando date('l, j/F/Y h:i a',$objeto->Data[$contador]). Se algo acontecer de errado retorna false
      $resposta=false;
	   $aDir=$aDirLC=$aFiles=$aExt=$aExtLC=$aFilesLC=$aSize=$aLastTime=array();
		$resposta=file_exists ($path);
      if ($resposta) {
	      $d = dir($path);
	      while($entry = $d->read()) {
	         $resposta=true;
	         if ($entry != "." && $entry != "..") {
	            if (is_dir($path."/".$entry)) {
	               $aDir[]=$entry;
                  $aDirLC[]=strtolower ($entry);
	            } else {
               	$pos=strrpos($entry,'.');
                  if ($pos==false){
	                  $aFiles[]=$entry;
	                  $aFilesLC[]=strtolower ($entry);
	                  $aExt[]=$aExtLC[]='';
                  } else {
	                  $aFiles[]=substr($entry,0,$pos);
	                  $aFilesLC[]=strtolower (substr($entry,0,$pos));
	                  $aExt[]=substr($entry,$pos);
	                  $aExtLC[]=strtolower(substr($entry,$pos));
                  }
	               $aSize[]=filesize($path."/".$entry);
	               $aLastTime[]=fileatime($path."/".$entry);
	            }
	         }
	      }
	      $d->close();
      }
      $this->Pastas=$aDir;
      $this->Arquivos=$aFiles;
      $this->Tamanho=$aSize;
      $this->Data=$aLastTime;
	   $this->PastasCaixaBaixa=$aDirLC;
	   $this->ArquivosCaixaBaixa=$aFilesLC;
	   $this->Extensao=$aExt;
	   $this->ExtensaoCaixaBaixa=$aExtLC;
	   return $resposta;
   } //Fim do método Lista

   function Ordena ($tipo,$ordemcrescente) {//Ordena as matrizes $tipo=0/nome,1/ext/extensao,2/tamanho,3/data,4/nomecn (caixa normal),5/extcn/extensaocn, $ordemcrescente=true/false (ordem crescente). Se algo acontecer de errado retorna false
	   if ($ordemcrescente) {
	      $o=SORT_ASC;
	   } else {
	      $o=SORT_DESC;
      }
		array_multisort ($this->PastasCaixaBaixa, $o, SORT_STRING,$this->Pastas);
      $resposta=false;
      $tipo=strtolower($tipo);
	   switch ($tipo) {
	      case 'nome': case 0:
				$resposta=array_multisort ($this->ArquivosCaixaBaixa, $o, SORT_STRING,$this->Arquivos,$this->ExtensaoCaixaBaixa,$this->Extensao,$this->Tamanho,$this->Data);
	         break;
	      case 'ext': case 'extensao': case 1:
				$resposta=array_multisort ($this->ExtensaoCaixaBaixa, $o, SORT_STRING,$this->Extensao,$this->ArquivosCaixaBaixa,$this->Arquivos,$this->Tamanho,$this->Data);
	         break;
	      case 'tamanho': case 2:
				$resposta=array_multisort ($this->Tamanho, $o, SORT_NUMERIC,$this->ArquivosCaixaBaixa,$this->ExtensaoCaixaBaixa,$this->Extensao,$this->Arquivos,$this->Data);
	         break;
	      case 'data': case 3:
				$resposta=array_multisort ($this->Data, $o, SORT_NUMERIC,$this->ArquivosCaixaBaixa,$this->ExtensaoCaixaBaixa,$this->Extensao,$this->Arquivos,$this->Tamanho);
	         break;
	      case 'nomecn': case 4:
				$resposta=array_multisort ($this->Arquivos, $o, SORT_STRING,$this->ArquivosCaixaBaixa,$this->Extensao,$this->ExtensaoCaixaBaixa,$this->Tamanho,$this->Data);
	         break;
	      case 'extcn':case 'extensaocn': case 5:
				$resposta=array_multisort ($this->Extensao, $o, SORT_STRING,$this->ExtensaoCaixaBaixa,$this->Arquivos,$this->ArquivosCaixaBaixa,$this->Tamanho,$this->Data);
	         break;
	      default:
	         break;
	   }
      return $resposta;
	} //Fim do método Ordena
} //Fim da classe Diretorio


function correctImageOrientation($filename, &$img ) {
  if (function_exists('exif_read_data')) {
    $exif = exif_read_data($filename);
    if($exif && isset($exif['Orientation'])) {
      $orientation = $exif['Orientation'];
      if($orientation != 1){
        //$img = imagecreatefromjpeg($filename);
        $deg = 0;
        switch ($orientation) {
          case 3:
            $deg = 180;
            break;
          case 6:
            $deg = 270;
            break;
          case 8:
            $deg = 90;
            break;
        }
        if ($deg) {
          $img = imagerotate($img, $deg, 0);        
        }
        // then rewrite the rotated image back to the disk as $filename 
        //imagejpeg($img, $filename, 95);
      } // if there is some rotation necessary
    } // if have the exif orientation info
  } // if function exists      
}



?>
