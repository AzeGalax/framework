<?php
	//$jsInclude=[];
	//$patternJs='/^(?:[A-Za-z0-9\-\.\_]+\.+js ?)$/i';
	//$countJs=0;
	//foreach($jsInclude as $val){
	//	if(preg_match($patternJs, $val)){
	//		echo "\t".'<script type="text/javascript" src="/js/'.$val.'"></script>';
	//		$countJs++;
	//	}
	//}
	//if($countJs>=1){
	//	echo "\r\n";
	//}
	displayMsg();
	require(constant('ROOT_PATH').'/bunker/layer-1/layer-2/mail.php');
?>	</body>
	<script type="text/javascript" src="/assets/out/js/jquery.min.js"></script>
	<script type="text/javascript" src="/assets/out/js/main.js"></script>
</html>