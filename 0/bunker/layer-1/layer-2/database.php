<?php
	$pdo_array = array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC);
	foreach($_SESSION['CONF']['DB_SERVER']['serverList'] as $key=>$val){
		try{
			$db = new PDO('mysql:host='.$val['serverHost'].';dbname='.$_SESSION['CONF']['DB_SERVER']['serverName'].';charset=utf8;', $val['serverUser'], $val['serverPasswd'], $pdo_array);
			unset($_SESSION['CONF']['DB_SERVER']['serverList'][$key]);
			array_unshift($_SESSION['CONF']['DB_SERVER']['serverList'][$key=$val]);
			break;
		}catch(PDOException $e1){
			writeLog("DATABASE ERROR : $e1");
		}
	}
?>