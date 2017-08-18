<?php
//START SESSION
	session_start();
//CONFIGURATION
	if(substr(trim(fgets(fopen(ROOT_PATH.'/bunker/conf.txt', 'r'))), 2)!='CONFIGURED'){
		require(ROOT_PATH.'/bunker/layer-1/firstConf.php');
		exit();
	}
//CONF READ
	if(!isset($_SESSION['CONF'])){
		require(ROOT_PATH.'/bunker/layer-1/conf.php');
	}
//DEFAULT DATE
	date_default_timezone_set($_SESSION['CONF']['DATE_TIMEZONE']);
//REQUIRE PHP MAIN FILE
	require(ROOT_PATH.'/bunker/layer-1/layer-2/define.php');
	require(ROOT_PATH.'/bunker/layer-1/layer-2/function.php');
	require(ROOT_PATH.'/bunker/layer-1/layer-2/database.php');
//GET HEAD AND BODY
	ob_start();
	require(ROOT_PATH.'/bunker/layer-1/head.php');
	$head=ob_get_clean();
	ob_start();
	require(ROOT_PATH.'/bunker/layer-1/body.php');
	$body=ob_get_clean();
?>