<?php
	//REQUIRE PHPMAILER CLASS
	require(ROOT_PATH.'/bunker/layer-1/modules/phpMailer/PHPMailerAutoload.php');

	//FUNCTION SENDMAIL
	function sendMail($to, $subject, $fileMail, $content, $attachment=[], $copyAdmin=false){
		//TEST
		if($to==null||$subject==null||$fileMail==null||!file_exists(ROOT_PATH.'/bunker/layer-1/modules/mailTemplate/'.$fileMail.'.php')){
			writeLog("MAIL PROBLEM(main parameters) : to : $to, subject : $subject, content : $content, access : ".file_exists(ROOT_PATH.'/bunker/layer-1/modules/mailTemplate/'.$fileMail.'.php').".");
			return null;
		}
		$attachmentDetails='';
		if(!empty($attachment)){
			foreach($attachment as $val){
				$attachmentDetails.=$val;
				if(!file_exists(ROOT_PATH.'/kale/assets/in/'.$val)){
					writeLog("MAIL PROBLEM(attachments) : $val not accessible.");
					return null;
				}
			}
		}
		//DEFAULT PARAMETER
		$phpMailer=new PHPMailer();
		//SMTP CONNECTION
		if($_SESSION['CONF']['MAIL_VERSION']==2){
			//SMTP USE
			$PHPMailer->isSMTP();
			$PHPMailer->Host=$_SESSION['CONF']['MAIL_SERVER']['mailHost'];
			$PHPMailer->SMTPAuth=true;
			$PHPMailer->Password=$_SESSION['CONF']['MAIL_SERVER']['mailPassword'];
			$PHPMailer->SMTPSecure=$_SESSION['CONF']['MAIL_SERVER']['mailSecureType'];//tls
			$PHPMailer->Port=587;
		}
		//GENERAL AND SENDING
		$PHPMailer->SMTPDebug=0;
		$PHPMailer->isHTML(true);
		$PHPMailer->CharSet="utf-8";
		$PHPMailer->Priority=3;
		//CONTENT EMAIL
		ob_start();
		require_once(ROOT_PATH.'/bunker/layer-1/modules/mailTemplate/'.$fileMail.'.php');
		$contentMail = ob_get_clean();
		//FRON, TO ...
		$PHPMailer->setFrom($_SESSION['CONF']['MAIL_RECEIVER'], "Info");
		$PHPMailer->addReplyTo($_SESSION['CONF']['MAIL_RECEIVER'], "Info");
		$PHPMailer->Username=$_SESSION['CONF']['MAIL_RECEIVER'];
		$PHPMailer->addAddress($to);
		if($copyAdmin==true){
			$PHPMailer->addBCC($_SESSION['CONF']['MAIL_RECEIVER']);
		}
		//SUBJECT, MESSAGE
		$PHPMailer->Subject=$subject;
		$PHPMailer->Body=$contentMail;
		//SEND
		if($PHPMailer->send()){
			return true;
		}
		writeLog("MAIL PROBLEM(send failed), to : $to, subject : $subject, content : $content, attachment = $attachmentDetails.");
		return false;
		//$PHPMailer->clearAddresses();
		//$PHPMailer->clearAllRecipients();
	}
?>