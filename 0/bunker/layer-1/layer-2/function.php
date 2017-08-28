<?php
//Ecrire des log dans un fichier
	function writeLog($logContent){
		$log = fopen(constant('ROOT_PATH').'/bunker/layer-1/modules/error/error.log', "a+");
		$date_log = date('Y-m-d H:i:s');
		fwrite($log, "$date_log ||| $logContent\r\n");
		fclose($log);
	}
//Test de connectivité
	function testUrl($url=null, $port=80, $timeout=3){
		if($url==null){return null;}
		if(is_int(strpos($url, 'http://'))){
			$url=str_replace('http://', '', $url);
		}
		if(is_int(strpos($url, 'https://'))){
			$url=str_replace('https://', '', $url);
		}
		return @fclose(@fsockopen($url,$port,$errno,$errstr,$timeout));
	}
//Retourne un numéro RANDOM
	function randString($length, $time=false){
		if($time==false){
			return(is_int($length))?substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ123456789'), 0, $length).'_'.time():null;
		}else{
			return(is_int($length))?substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ123456789'), 0, $length):null;
		}
	}
//Retourne une ressource de connexion FTP ou null
	//function ftpCon($ip, $port, $user, $passwd, $pasv=true, $timeout=15){
	//	if($ftpCon = @ftp_connect($ip, $port, $timeout)){
	//		if(ftp_login($ftpCon, $user, $passwd)){
	//			ftp_pasv($ftpCon, $pasv);
	//			return $ftpCon;
	//		}else{
	//			//sendMail($to, $subject, $fileMail, $content, $attachment=[], $copyAdmin=false)
	//			sendMail(constant('MAIL_ADMIN'), 'FTP PROBLEM', 'admin', array('mail_content'=>"Problème d'identification avec les data suivantes : IP -><b>$ip</b>, PORT-><b>$port</b>, USER-><b>$user</b>, PASSWORD-><b>$passwd</b>"));
	//		}
	//	}else{
	//		//sendMail($to, $subject, $fileMail, $content, $attachment=[], $copyAdmin=false)
	//		sendMail(constant('MAIL_ADMIN'), 'FTP PROBLEM', 'admin', array('mail_content'=>"Problème d'identification avec les data suivantes : IP -><b>$ip</b>, PORT-><b>$port</b>, USER-><b>$user</b>, PASSWORD-><b>$passwd</b>"));
	//	}
	//	return null;
	//}
//Montrer les variables de session à chaque chargements
	function displayMsg(){
		if(!empty($_SESSION['ALERT'])){
			echo "<div class='alert-container'>";
			foreach($_SESSION['ALERT'] as $key => $val){
				foreach($val as $val2){
					echo "<div class='alert alert-$key'><span>$val2</span></div>";
					unset($_SESSION['ALERT'][$key]);
				}
			}
			echo "</div>";
			if(empty($_SESSION['ALERT'])){unset($_SESSION['ALERT']);}
		}
	}
?>