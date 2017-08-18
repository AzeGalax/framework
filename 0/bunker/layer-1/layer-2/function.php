<?php
	function writeLog($logContent){
		$log = fopen(constant('ROOT_PATH').'/bunker/layer-1/modules/error/error.log', "a+");
		$date_log = date('Y-m-d H:i:s');
		fwrite($log, "$date_log ||| $logContent\r\n");
		fclose($log);
	}

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
?>