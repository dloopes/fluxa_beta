<?php
namespace Fluxa\Business;

use Fluxa\Entity\Recurso;
use Fluxa\Entity\Fluxo;
use Fluxa\Entity\FluxoMensagem;
use Fluxa\Entity\TemplateEmail;
use Fluxa\Business\FluxoBusiness;
use Fluxa\Business\UsuarioBusiness;
use \PHPMailer as PHPMailer;

class EmailBusiness {

	function __construct() {

	}

	public function enviarEmailCadastro($chave, $email) {

		$msgEmail = "Confirme seu email clicando nesse <a href='" . URI_SISTEMA . "cadastro/email/" . $chave . "'>link</a>";

		return $this->enviarEmail($msgEmail, $email);

	}

	public function enviarEmailRecuperarSenha($chave, $email) {

		$msgEmail = "Redefina sua senha clicando nesse <a href='" . URI_SISTEMA . "redefinir_senha/" . $chave . "'>link</a>";

		return $this->enviarEmail($msgEmail, $email);

	}

	public function enviarEmailNovoFluxo(Fluxo $fluxo) {

		$titulo = "Novo Fluxo";
		$srcBanner = URI_SISTEMA ."dist/img/fluxo_banner_email.jpg";
		$labelButton = "Acesse ";	
		$linkButton = URI_SISTEMA . "fluxo/".$fluxo->getId();	

		$mensagem = "";

		$recurso = $fluxo->getRecurso();
		$usuarioIniciouFluxo = $fluxo->getUsuarioIniciouFluxo();
		$usuarioRecebeuFluxo = $fluxo->getUsuarioRecebeuFluxo();

		if($recurso->getTipo() == Recurso::TIPO_POTENCIALIDADE){
			$mensagem = "<b>".ucfirst($usuarioIniciouFluxo->getNome())."</b> solicitou <b>".$fluxo->getRecurso()->getNome()."</b> ofertado por você.";
		}

		if($recurso->getTipo() == Recurso::TIPO_POSSIBILIDADE){
			$mensagem = "<b>".ucfirst($usuarioIniciouFluxo->getNome())."</b> ofereceu <b>".$fluxo->getRecurso()->getNome()."</b> necessitado por você.";
		}

		$templateEmail = new TemplateEmail($titulo, $mensagem, $srcBanner, $labelButton, $linkButton);	

		if ( ! is_null($usuarioRecebeuFluxo)){

		         return $this->enviarEmail($templateEmail->getHTML(), $usuarioRecebeuFluxo->getEmail());
		}


	}

	public function enviarEmailNovoFluxoMensagem(FluxoMensagem $fluxoMensagem) {

		$fluxoBusiness = new FluxoBusiness();
		$usuarioBusiness = new UsuarioBusiness();

		$fluxo = $fluxoBusiness->buscarPorId($fluxoMensagem->getIdFluxo());

		$usuarioRemetente = $fluxoMensagem->getUsuarioRemetente();
		$usuarioDestinatario = $fluxoMensagem->getUsuarioDestinatario();

		$titulo = "Nova Mensagem";
		$srcBanner = URI_SISTEMA ."dist/img/fluxo_banner_email_msg_2.jpg";
		$labelButton = "Acesse ";	
		$linkButton = URI_SISTEMA . "fluxo/".$fluxo->getId();
		$mensagem = "<b>".ucfirst($usuarioRemetente->getNome())."</b> enviou uma nova mensagem para você.";	

		$templateEmail = new TemplateEmail($titulo, $mensagem, $srcBanner, $labelButton, $linkButton);	

		return $this->enviarEmail($templateEmail->getHTML(), $usuarioDestinatario->getEmail());

	}

	private function enviarEmail($msgHtml, $email) {

		$mail = new PHPMailer();
		$mail->SMTP_PORT = "587"; // ajusto a porta de smt a ser utilizada. Neste caso, a 587 que o GMail utiliza
		$mail->SMTPSecure = "tls"; // ajusto o tipo de comunicação a ser utilizada, no caso, a TLS do GMail

		$mail->IsSMTP(); // ajusto o email para utilizar protocolo SMTP
		//$mail->Host = "smtp.hostinger.com.br"; // especifico o endereço do servidor smtp do GMail
		$mail->Mailer = 'smtp.hostinger.com.br';
		$mail->SMTPAuth = true; // ativo a autenticação SMTP, no caso do GMail, é necessário
		$mail->Username = "sistema@fluxa.xyz"; // Usuário SMTP do GMail
		$mail->Password = "coloquesuasenha"; // Senha do usuário SMTP do GMail


		$mail->From = "sistema@fluxa.xyz"; // Email de quem envia o email
		$mail->FromName = "Fluxa"; // Nome de quem envia o email
		$mail->AddAddress($email); // Endereço e nome de quem vai receber o email, o nome é opcional

		//$mail->WordWrap = 50; // quebra linha sempre que uma linha atingir 50 caracteres
		$mail->IsHTML(true); // ajusto envio do email no formato HTML

		$mail->Subject = "Fluxa"; // Aqui colocar o assunto do email
		$mail->Body = $msgHtml;

        $SEND_EMAIL = true;
		if ( defined("SEND_EMAIL") ){
                 $SEND_EMAIL =  SEND_EMAIL;
		}

		if ( $SEND_EMAIL ){ //ambiente de testes não precisamos enviar email.
				if (!$mail->Send()) {
					return false;
				}

		}

	
		return true;

	}

}
