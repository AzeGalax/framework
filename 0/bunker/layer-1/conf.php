<?php
$_SESSION['CONF']=[];
$confRead=file(ROOT_PATH.'/bunker/conf.txt', FILE_IGNORE_NEW_LINES);
foreach($confRead as $val){
	if(substr($val, 0, 2)!='//'&&!empty($val)){
		$valId=str_replace(substr($val, strpos($val, '|')), '', $val);
		$valContent=str_replace('|', '', substr($val, strpos($val, '|')));
		$_SESSION['CONF'][$valId]=$valContent;
	}
}
$conf=$_SESSION['CONF'];

//DB
//1:No connection
//2:Connection
if(!isset($conf['DB_VERSION'])||!in_array($conf['DB_VERSION'],[1,2])||$conf['DB_VERSION']=='DEFAULT'){
	$conf['DB_VERSION']=1;
}
//Empty array
//Full array
//a:2:{s:10:"serverName";s:1:"t";s:10:"serverList";a:1:{s:8:"server-1";a:3:{s:10:"serverUser";s:0:"";s:12:"serverPasswd";s:0:"";s:10:"serverHost";s:0:"";}}}
if($conf['DB_VERSION']==2){
	if(isset($conf['DB_SERVER'])&&$conf['DB_SERVER']!='DEFAULT'){
		if(!empty($conf['DB_SERVER'])){
			$conf['DB_SERVER']=unserialize($conf['DB_SERVER']);
			if(!isset($conf['DB_SERVER']['serverName'])||empty($conf['DB_SERVER']['serverName'])){
				$conf['DB_VERSION']=1;
				$conf['DB_SERVER']=null;
			}
			$conf['DB_SERVERNAME']=$conf['DB_SERVER']['serverName'];
			foreach($conf['DB_SERVER']['serverList'] as $val){
				if(!isset($val['serverUser'])||!isset($val['serverPasswd'])||!isset($val['serverHost'])||empty($val['serverUser'])||empty($val['serverPasswd'])||empty($val['serverHost'])){
					$conf['DB_SERVER']=null;
					$conf['DB_VERSION']=1;
				}
			}
			$conf['DB_SERVER']=$conf['DB_SERVER']['serverList'];
		}else{
			$conf['DB_SERVER']=null;
			$conf['DB_VERSION']=1;
		}
	}else{
		$conf['DB_SERVER']=null;
		$conf['DB_VERSION']=1;
	}
}else{
	$conf['DB_SERVER']=null;
	$conf['DB_VERSION']=1;
}
//MAIL
//1:No Auth
//2:Auth
	if(!isset($conf['MAIL_VERSION'])||!in_array($conf['MAIL_VERSION'], array(1,2))){
		$conf['MAIL_VERSION']=1;
		$conf['MAIL_SERVER']=null;
	}
//MAIL CONFIG
//a:3:{s:8:"mailHost";s:0:"";s:12:"mailPassword";s:0:"";s:14:"mailSecureType";s:0:"";}
	if($conf['MAIL_VERSION']==2){
		if(isset($conf['MAIL_SERVER']) && $conf['MAIL_SERVER']!='DEFAULT'){
			if(!empty($conf['MAIL_SERVER'])){
				$conf['MAIL_SERVER']=unserialize($conf['MAIL_SERVER']);
				$mailExt=array('ssl', 'tls');
				foreach($conf['MAIL_SERVER'] as $key => $val){
					if(!empty($val)){
						$conf['MAIL_SERVER'][$key]=$val;
					}else{
						$conf['MAIL_VERSION']=1;
						$conf['MAIL_SERVER']=null;
						break;
					}
				}
			}else{
				$conf['MAIL_VERSION']=1;
				$conf['MAIL_SERVER']=null;
			}
		}else{
			$conf['MAIL_VERSION']=1;
			$conf['MAIL_SERVER']=null;
		}
	}
//REGEXP
$patternMail='/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD';
if(!isset($conf['MAIL_RECEIVER'])||!preg_match($patternMail, $conf['MAIL_RECEIVER'])){
	$conf['MAIL_RECEIVER']='clementloirepro@gmail.com';
}

//DATE TIMEZONE
$timezone=array('Europe/Amsterdam','Europe/Andorra','Europe/Athens','Europe/Belfast','Europe/Belgrade','Europe/Berlin','Europe/Bratislava','Europe/Brussels','Europe/Bucharest','Europe/Budapest','Europe/Busingen','Europe/Chisinau','Europe/Copenhagen','Europe/Dublin','Europe/Gibraltar','Europe/Guernsey','Europe/Helsinki','Europe/Isle_of_Man','Europe/Istanbul','Europe/Jersey','Europe/Kaliningrad','Europe/Kiev','Europe/Lisbon','Europe/Ljubljana','Europe/London','Europe/Luxembourg','Europe/Madrid','Europe/Malta','Europe/Mariehamn','Europe/Minsk','Europe/Monaco','Europe/Moscow','Europe/Nicosia','Europe/Oslo','Europe/Paris','Europe/Podgorica','Europe/Prague','Europe/Riga','Europe/Rome','Europe/Samara','Europe/San_Marino','Europe/Sarajevo','Europe/Simferopol','Europe/Skopje','Europe/Sofia','Europe/Stockholm','Europe/Tallinn','Europe/Tirane','Europe/Tiraspol','Europe/Uzhgorod','Europe/Vaduz','Europe/Vatican','Europe/Vienna','Europe/Vilnius','Europe/Volgograd','Europe/Warsaw','Europe/Zagreb','Europe/Zaporozhye','Europe/Zurich');
if(!isset($conf['DATE_TIMEZONE'])||!in_array($conf['DATE_TIMEZONE'], $timezone)){
	$conf['DATE_TIMEZONE']='Europe/Paris';
}

//EXTERNAL RESSOURCES
if(!isset($conf['EXTERNAL_SERVER'])||!filter_var($conf['EXTERNAL_SERVER'], FILTER_VALIDATE_URL)||$conf['EXTERNAL_SERVER']=='DEFAULT'){
	$conf['EXTERNAL_SERVER']='/assets/out';
}

//LANGUAGE
$language_arr=array('ch', 'en', 'fr', 'de');
if(!isset($conf['WEBSITE_LANGUAGE'])||!in_array($conf['WEBSITE_LANGUAGE'], $language_arr)){
	$conf['WEBSITE_LANGUAGE']='en';
}

//FINAL
$_SESSION['CONF']=$conf;
?>