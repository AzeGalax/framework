<?php
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

	$timezone=array('Europe/Amsterdam','Europe/Andorra','Europe/Athens','Europe/Belfast','Europe/Belgrade','Europe/Berlin','Europe/Bratislava','Europe/Brussels','Europe/Bucharest','Europe/Budapest','Europe/Busingen','Europe/Chisinau','Europe/Copenhagen','Europe/Dublin','Europe/Gibraltar','Europe/Guernsey','Europe/Helsinki','Europe/Isle_of_Man','Europe/Istanbul','Europe/Jersey','Europe/Kaliningrad','Europe/Kiev','Europe/Lisbon','Europe/Ljubljana','Europe/London','Europe/Luxembourg','Europe/Madrid','Europe/Malta','Europe/Mariehamn','Europe/Minsk','Europe/Monaco','Europe/Moscow','Europe/Nicosia','Europe/Oslo','Europe/Paris','Europe/Podgorica','Europe/Prague','Europe/Riga','Europe/Rome','Europe/Samara','Europe/San_Marino','Europe/Sarajevo','Europe/Simferopol','Europe/Skopje','Europe/Sofia','Europe/Stockholm','Europe/Tallinn','Europe/Tirane','Europe/Tiraspol','Europe/Uzhgorod','Europe/Vaduz','Europe/Vatican','Europe/Vienna','Europe/Vilnius','Europe/Volgograd','Europe/Warsaw','Europe/Zagreb','Europe/Zaporozhye','Europe/Zurich');
	$language_arr=array('ch', 'en', 'fr', 'de');

	if(isset($_POST) AND !empty($_POST)){
		if(isset($_POST['dbConf']) AND !empty($_POST['dbConf']) AND isset($_POST['mailConf']) AND !empty($_POST['mailConf']) AND isset($_POST['languageConf']) AND !empty($_POST['languageConf']) AND isset($_POST['timezoneConf']) AND !empty($_POST['timezoneConf']) AND isset($_POST['extConf']) AND !empty($_POST['extConf'])){
			$file="//CONFIGURED\r\n";

			//DATABASE
			$file.="//DATABASE\r\n";
			if($_POST['dbConf']==1){
				$file.="DB_VERSION|1|\r\n";
				$file.='DB_SERVER|a:2:{s:10:"serverName";s:0:"";s:10:"serverList";a:1:{s:8:"server-1";a:3:{s:10:"serverUser";s:0:"";s:12:"serverPasswd";s:0:"";s:10:"serverHost";s:0:"";}}}|'."\r\n";
			}elseif($_POST['dbConf']==2){
				if(isset($_POST['dbName']) AND !empty($_POST['dbName']) AND isset($_POST['dbUrl']) AND !empty($_POST['dbUrl']) AND isset($_POST['dbUser']) AND !empty($_POST['dbUser']) AND isset($_POST['dbPassword']) AND !empty($_POST['dbPassword'])){
					$dbName=htmlspecialchars($_POST['dbName']);
					$dbUrl=htmlspecialchars($_POST['dbUrl']);
					$dbUser=htmlspecialchars($_POST['dbUser']);
					$dbPassword=htmlspecialchars($_POST['dbPassword']);
					try{
						$db = new PDO('mysql:host='.$dbUrl.';dbname='.$dbName.';charset=utf8;', $dbUser, $dbPassword);
						$dbArray=serialize(['serverName'=>$dbName,'serverList'=>['server-1'=>['serverUser'=>$dbUser,'serverPasswd'=>$dbPassword,'serverHost'=>$dbUrl]]]);
						$file.="DB_VERSION|2|\r\n";
						$file.="DB_SERVER|$dbArray|\r\n";
					}catch(PDOException $e){
						$file.="DB_VERSION|1|\r\n";
						$file.='DB_SERVER|a:2:{s:10:"serverName";s:0:"";s:10:"serverList";a:1:{s:8:"server-1";a:3:{s:10:"serverUser";s:0:"";s:12:"serverPasswd";s:0:"";s:10:"serverHost";s:0:"";}}}|'."\r\n";
					}
				}
			}
			//MAIL
			$file.="//MAIL\r\n";
			if($_POST['mailConf']==1){
				$file.="MAIL_VERSION|1|\r\n";
			}elseif($_POST['mailConf']==2){
				$mailUrl=$_POST['mailUrl'];
				if(testUrl($mailUrl,25) OR testUrl($mailUrl,465)){
					$dMail=serialize(['mailHost'=>$_POST['mailUrl'],'mailPassword'=>$_POST['mailPassword'],'mailSecureType'=>$_POST['mailSecurity']]);
					$file.="MAIL_VERSION|2|\r\n";
					$file.="MAIL_SERVER|$dMail|\r\n";
				}
			}
			if(isset($_POST['mailAt']) AND !empty($_POST['mailAt'])){
				if(filter_var($_POST['mailAt'], FILTER_VALIDATE_EMAIL)){
					$cMail=$_POST['mailAt'];
					$file.="MAIL_RECEIVER|$cMail|\r\n";
				}else{
					$file.="MAIL_RECEIVER|clementloirepro@gmail.com|\r\n";
				}
			}else{
				$file.="MAIL_RECEIVER|clementloirepro@gmail.com|\r\n";
			}
			//DATE
			$file.="//DATE\r\n";
			$cDate=$_POST['timezoneConf'];
			if(in_array($cDate, $timezone)){
				$file.="DATE_TIMEZONE|$cDate|\r\n";
			}else{
				$file.="DATE_TIMEZONE|Europe/Paris|\r\n";
			}
			//LANG
			$file.="//LANG\r\n";
			$cLang=$_POST['languageConf'];
			if(in_array($cLang, $language_arr)){
				$file.="WEBSITE_LANGUAGE|$cLang|\r\n";
			}else{
				$file.="WEBSITE_LANGUAGE|fr|\r\n";
			}
			//EXT CONF
			$file.="//EXTERNAL RESSOURCES\r\n";
			$cExt=$_POST['extUrl'];
			if(testUrl($cExt,80)){
				$file.="EXTERNAL_SERVER|$cExt|\r\n";
			}else{
				$file.="EXTERNAL_SERVER|DEFAULT|\r\n";
			}
		}
		$fileC=fopen('../bunker/conf.txt', 'a+');
		ftruncate($fileC, 0);
		fwrite($fileC, $file);
		fclose($fileC);
		header('Location:/');
	}
?><!DOCTYPE html>
<html lang="fr">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
		<meta name="author" content="Clément LOIRE">
		<link rel="author" href="https://www.clement-loire.fr">
		<link rel="icon" type="image/png" href="/assets/out/img/icon/ico.png">
		<link rel="stylesheet" type="text/css" href="/assets/out/css/grid.css">
		<link rel="stylesheet" type="text/css" href="/assets/out/css/material.css">
		<link rel="stylesheet" type="text/css" href="/assets/out/css/main.css">
		<link rel="stylesheet" type="text/css" href="/assets/out/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato|Montserrat|Roboto|Pacifico|Varela+Round">
		<title>Configuration du site</title>
	</head>
	<body>
		<header>
			<a href="">
				<img src="/assets/out/img/icon/logo.png">
			</a>
			<div class="menu-pusher">
				<div id="menu-pusher"></div>
			</div>
		</header>
		<nav>
			<div class="menu-left">
				<div class="menu-left-top">
					<div class="menu-elements-container">
						<!--Menu-->
						<a href="" class="menu-element-container">
							<span class="menu-element-2-caller"><i class="fa fa-home" aria-hidden="true"></i>Accueil</span>
						</a>
						<!--Menu-->
						<div>
							<span class="menu-element-1-caller menu-element-container"><i class="fa fa-sticky-note" aria-hidden="true"></i>Sous-Menus<div class="menu-caller"><i class="fa fa-angle-down" aria-hidden="true"></i></div></span>
							<div class="menu-element-1-container">
								<a href="" class="menu-element-1-in">Sous-Menus 1</a>
								<a href="" class="menu-element-1-in">Sous-Menus 2</a>
								<a href="" class="menu-element-1-in">Sous-Menus 3</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</nav>
		<section class="main-section clearfix">
			<form method="POST" action="" class="clearfix" novalidate>
				<h1 class="center black">Configuration du site</h1>
				<div class="grid-l-1"></div>
				<div class="grid-l-4 clearfix">
					<div class="card black-all grid-l-12">
						<h3 class="center">Base de données</h3>
						<div>
							<div class="form-group">
								<select name="dbConf">
									<option value="1">NON</option>
									<option value="2">OUI</option>
								</select>
								<label class="control-label" for="select">Utilisation d'une ou plusieurs base de données</label><i class="bar"></i>
							</div>
							<div id="conf-db">
								<h4>Configuration de la base de données</h4>
								<div class="form-group">
									<input type="text" name="dbName" required="required">
									<label class="control-label" for="input">Nom de la base de données</label><i class="bar"></i>
								</div>
								<div id="dbList" data-id="1">
									<div class="dbList dbList1">
										<h5>Base de données n°1</h5>
										<div class="form-group">
											<input type="text" name="dbUrl" required="required">
											<label class="control-label" for="input">Adresse du serveur</label><i class="bar"></i>
										</div>
										<div class="form-group">
											<input type="text" name="dbUser" required="required">
											<label class="control-label" for="input">Nom d'utilisateur</label><i class="bar"></i>
										</div>
										<div class="form-group">
											<input type="text" name="dbPassword" required="required">
											<label class="control-label" for="input">Mot de passe</label><i class="bar"></i>
										</div>
									</div>
								</div>
								<!--<div class="center">
									<img src="/assets/out/img/icon/32/black/add.png" id="addList">
								</div>-->
							</div>
						</div>
					</div>
					<div class="card black-all grid-l-12">
						<h3 class="center">Mail</h3>
						<div>
							<div class="form-group">
								<select name="mailConf">
									<option value="1">NON</option>
									<option value="2">OUI</option>
								</select>
								<label class="control-label" for="select">Utilisation d'un serveur mail distant</label><i class="bar"></i>
							</div>
							<div id="conf-mail">
								<h4>Configuration du serveur mail distant</h4>
								<div class="form-group">
									<input type="text" name="mailUrl" required="required">
									<label class="control-label" for="input">Adresse du serveur</label><i class="bar"></i>
								</div>
								<div class="form-group">
									<input type="text" name="mailPassword" required="required">
									<label class="control-label" for="input">Mot de passe</label><i class="bar"></i>
								</div>
								<div class="form-group">
									<select name="mailSecurity">
										<option value="tls">TLS</option>
										<option value="ssl">SSL</option>
									</select>
									<label class="control-label" for="select">Type de sécurité</label><i class="bar"></i>
								</div>
							</div>
							<div>
								<h4>Configuration des mails</h4>
								<div class="form-group">
									<input type="email" name="mailAt" required="required">
									<label class="control-label" for="input">Adresse mail de l'administrateur</label><i class="bar"></i>
								</div>
							</div>
						</div>
					</div>
					<div class="card black-all grid-l-12">
						<h3 class="center">Serveur de ressources</h3>
						<div>
							<div class="form-group">
								<select name="extConf">
									<option value="1">NON</option>
									<option value="2">OUI</option>
								</select>
								<label class="control-label" for="select">Utilisation d'un serveur de ressources distant</label><i class="bar"></i>
							</div>
							<div id="conf-ext">
								<h4>Configuration du serveur de ressources distant</h4>
								<div class="form-group">
									<input type="text" name="extUrl" required="required">
									<label class="control-label" for="input">Adresse du serveur</label><i class="bar"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="grid-l-2"></div>
				<div class="grid-l-4 clearfix">
					<div class="card black-all grid-l-12">
						<h3 class="center">Date</h3>
						<div class="form-group">
							<select name="timezoneConf">
								<?php
								foreach($timezone as $val){
								?><option value="<?=$val;?>"><?=$val;?></option><?php
								}
								?>
							</select>
							<label class="control-label" for="select">Sélection de la zone du site</label><i class="bar"></i>
						</div>
					</div>
					<div class="card black-all grid-l-12">
						<h3 class="center">Langue</h3>
						<div class="form-group">
							<select name="languageConf">
								<?php
								foreach($language_arr as $val){
								?><option value="<?=$val;?>"><?=$val;?></option><?php
								}
								?>
							</select>
							<label class="control-label" for="select">Sélection de la langue du site</label><i class="bar"></i>
						</div>
					</div>
				</div>
				<div class="grid-l-12">
					<div class="button-container">
						<button class="button" type="submit"><span>Submit</span></button>
					</div>
				</div>
			</form>
		</section>
	</body>
	<script type="text/javascript" src="/assets/out/js/jquery.min.js"></script>
	<script type="text/javascript" src="/assets/out/js/main.js"></script>
	<script type="text/javascript" src="/assets/out/js/firstConf.js"></script>
</html>