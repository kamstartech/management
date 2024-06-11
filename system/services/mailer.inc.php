<?php
class mailer {

	public $core;
	public $service;
	public $mail;

	public $name;
	public $study;
	public $filename;

	public function configService() {
		$this->service->output = FALSE;

		return $this->service;
	}

	public function runService($core) {
		$this->core = $core;
	}

	public function newMail($mailTemplate, $recipient = NULL, $name = NULL, $study = NULL, $filename){
		$mailTemplate = $this->core->conf['conf']['templatePath'] . "mail/" . $mailTemplate . ".json";

		$this->name = $name;
		$this->study = $study;	
		$this->filename = $filename;	


		if (file_exists($mailTemplate)) {
			$file = file_get_contents($mailTemplate);
			$mailTemplate = json_decode($file);
		}

		$mailTemplate = $this->parseMailTemplate($mailTemplate);
		$this->sendMail($mailTemplate, $recipient);
	}

	private function parseMailTemplate($mailTemplate){
		$data = array(
			"INSTITUTION"     => $this->core->conf['conf']['institutionName'],
			"NAME"		  => $this->name,
			"UID"		  => $_SESSION['username'],
			"PASSWORD"	  => $_SESSION['password'],
			"MESSAGE"	  => $_SESSION['message'],
			"STUDY" 	  => $this->study
		);

		foreach ($data as $var => $value){
			$mailTemplate->Content = str_replace('%'.$var.'%', $value, $mailTemplate->Content);
		}


		return $mailTemplate;

	}

	private function sendMail($mailTemplate, $recipient){

		include $this->core->conf['conf']['libPath'] . 'phpmailer/src/Exception.php';
		include $this->core->conf['conf']['libPath'] . 'phpmailer/src/PHPMailer.php';
		include $this->core->conf['conf']['libPath'] . 'phpmailer/src/SMTP.php';

		$mail = new PHPMailer\PHPMailer\PHPMailer();
		try {
			//$mail->SMTPDebug = 2;
			$mail->isSMTP();
			$mail->Host = 'mail.edenuniversity.edu.zm';  
			$mail->SMTPAuth = true;
			$mail->Username = 'portal@edenuniversity.edu.zm';
			$mail->Password = 'Eden@2022d3a017bd1f8a2c9c109b40d7eec4b3e688cdb47b'; 

			$mail->SMTPAutoTLS = true;
			$mail->SMTPSecure = true;
			$mail->Port = 465;

			$mail->setFrom('portal@edenuniversity.edu.zm', 'CoreLink Consulting');
			$mail->addAddress($recipient, $this->name);

			if($this->filename != '' && $this->filename != NULL){
				$mail->addAttachment($this->filename, "letter.pdf");
			}

			$mail->isHTML(true); 
 			$mail->Subject = $mailTemplate->Subject;
			$mail->Body    = nl2br($mailTemplate->Content);
			$mail->AltBody = $mailTemplate->Content;

			if(!$mail->Send()) {
			   echo 'Message could not be sent.';
			   echo 'Mailer Error: ' . $mail->ErrorInfo;
			   exit;
			}

			echo '<div class="successpopup">EMAIL SENT TO '.$recipient.' ('.$this->name.')</div>';

		} catch (Exception $e) {
			echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
			die();
		}

	}
}
?>