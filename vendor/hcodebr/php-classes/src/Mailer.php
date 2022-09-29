<?php 
namespace Hcode;

use Rain\Tpl;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

class Mailer{

	const USERNAME = 'seu@gmail.com';
	const PASSWORD = 'SuaSenhaAppDoGmail';
	const NAME_FROM = 'Seu Nome';
	
	private $mail;

	public function __construct($toAdress, $toName, $subject, $tplName, $data = array())
	{

		$config = array(

			"tpl_dir" 	=> $_SERVER['DOCUMENT_ROOT']."/views/email/", // pasta para pegar arquivos html
			"cache_dir" => $_SERVER['DOCUMENT_ROOT']."/views-cache/", //tpl precisa de um cache
			"debug"     => "false"
		);

		Tpl::configure($config);
			
		$tpl = new Tpl;

		foreach($data as $key => $value) {
			$tpl->assign($key, $value);
		}
		
		$html = $tpl->draw($tplName, true);//true para não jogar na tela e sim na variável

		//Create a new PHPMailer instance
		$this->mail = new PHPMailer(true);

		try {
		    //Server settings
		    $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
		    $this->mail->isSMTP();                                            //Send using SMTP
		    $this->mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
		    $this->mail->SMTPAuth   = true;                                   //Enable SMTP authentication
		    $this->mail->Username   = Mailer::USERNAME;                     //SMTP username
		    $this->mail->Password   = Mailer::PASSWORD;                               //SMTP password
		    $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
		    $this->mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

		    //Recipients
		    $this->mail->setFrom(Mailer::USERNAME, Mailer::NAME_FROM);
		    $this->mail->addAddress($toAdress, $toName);     //Add a recipient
		    //$this->mail->addReplyTo('info@example.com', 'Information');
		    //$this->mail->addCC('cc@example.com');
		    //$this->mail->addBCC('bcc@example.com');

		    //Attachments
		    //$this->mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
		    //$this->mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

		    //Content
		    $this->mail->isHTML(true);                                  //Set email format to HTML
		    $this->mail->Subject = $subject;
		    $this->mail->Body    = $html;
		    $this->mail->AltBody = 'This is the body in plain text for non-HTML mail clients';


		} catch (Exception $e) {
	    echo "Não foi possível enviar o email, tente novamente. Mailer Error: {$this->mail->ErrorInfo}";
		}

	}
	public function send()
	{
		return $this->mail->send();
	}
}

?>